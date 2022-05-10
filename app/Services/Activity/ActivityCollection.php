<?php
/**
 * Created by PhpStorm.
 * User: Dave
 * Date: 9/14/2018
 * Time: 9:13 PM
 */

namespace App\Services\Activity;

use DB;
use App\Constants;
use App\Models\Activity;
use App\Models\Subscription;
use App\Models\Package;

/**
 * Class ActivityCollection
 * @package App\Services\Activity
 */
class ActivityCollection
{

    public $meta = [];

    /**
     * @var Activity
     */
    public $activity;
    public $subscription;
    public $package;

    /**
     * ActivityCollection constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity, Subscription $subscription, Package $package)
    {
        $this->activity = $activity;
        $this->subscription = $subscription;
        $this->package = $package;
    }

    /**
     * @param $builder
     * @param array $request
     * @return mixed
     */
    public function order($builder, $request = [])
    {
        $or = isset($request['order']) ? $request['order'] : 'DESC';

        $by = isset($request['order_by']) ? $request['order_by'] : 'created_at';

        if (!in_array(strtoupper($or), ['ASC', 'DESC'])) {
            $or = 'DESC';
        }

        $this->meta['order'] = $or;
        $this->meta['order_by'] = $by;

        return $builder->orderBy($by, $or);
    }

    /**
     * @param $builder
     * @param array $request
     * @return mixed
     */
    public function base($builder, $request = [])
    {
        $builder = $this->order($builder, $request);

        if (isset($request['entity_id'])) {
            $builder = $builder->where('entity_id', $request['entity_id']);
            $this->meta['entity_id'] = $request['entity_id'];
        }

        if (isset($request['type'])) {
            $builder = $builder->where('type', $request['type']);
            $this->meta['type'] = $request['type'];
        }

        if (isset($request['q'])) {
            $keyword = '%' . $request['q'] . '%';
            $builder = $builder->where('description', 'like', $keyword);
            $this->meta['q'] = $request['q'];
        }

        return $builder;
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function system($request = [])
    {
        $builder = $this->activity->select('*');

        $request['type'] = Constants::ACTIVITY_SYSTEM;

        $builder = $this->base($builder, $request);

        $limit = isset($request['limit']) ? (int)$request['limit'] : 25;

        return $builder->paginate($limit);
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function attendance($request = [])
    {
        $builder = $this->activity->select([
            'activities.*', 'packages.name AS package_name', 'currSubscription.status AS status', 'currSubscription.expires_at AS expires_at', 'users.name', 'users.id AS user_id', 'users.avatar', 'users.email', 'users.is_admin AS is_admin'
        ]);

        $builder =  $builder->join('users', 'users.id', '=', 'activities.entity_id');
        

        $builder = $builder->leftJoin(DB::raw('(SELECT * from subscriptions order by id desc limit 1)
        AS "currSubscription"'), 
        function($join)
        {
           $join->on('currSubscription.user_id', '=', 'activities.entity_id');
        });        

        $builder = $builder->leftJoin('packages', 'packages.id', '=', 'currSubscription.package_id');

        $builder = $builder->where('is_admin', false);

        $request['type'] = Constants::ACTIVITY_ATTENDANCE;

        $builder = $this->base($builder, $request);

        $limit = isset($request['limit']) ? (int)$request['limit'] : 25;

        return $builder->paginate($limit);
    }
}