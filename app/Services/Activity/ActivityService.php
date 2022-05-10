<?php
/**
 * Created by PhpStorm.
 * User: Dave
 * Date: 9/14/2018
 * Time: 9:13 PM
 */

namespace App\Services\Activity;

use App\Constants;
use App\Models\Activity;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DateTime;
use Exception;

/**
 * Class ActivityService
 * @package App\Services\Activity
 */
class ActivityService
{
    /**
     * @var Activity
     */
    public $activity;
    /**
     * @var Subscription
     */
    protected $subscription;
    /**
     * ActivityService constructor.
     * @param Activity $activity
     * @param Subscription $subscription
     */
    public function __construct(Activity $activity, Subscription $subscription)
    {
        $this->activity = $activity;
        $this->subscription = $subscription;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $results = $this->activity->find($id);

        if (!$results) {
            throw new ModelNotFoundException();
        }

        return $results;
    }

    /**
     * @param $userId
     * @param $description
     * @return mixed
     */
    public function attend($userId, $description)
    {
        try {
            $date_now = new DateTime();
            // $subscription = $this->subscription::where('user_id', $userId)
            //                     ->where('status', 'active')                                
            //                     ->whereDate('expires_at', '>', $date_now)
            //                     ->firstOrFail();                                    
            return $this->activity->create([
                'entity_id' => $userId,
                'type' => Constants::ACTIVITY_ATTENDANCE,
                'description' => "$description",
            ]);           
        }
        catch(Exception $e) {
            throw new Exception("No active subscription");
        }                     
    }

    /**
     * @param $id
     * @param $description
     */
    public static function log($id, $description)
    {
        Activity::create([
            'entity_id' => $id,
            'type' => Constants::ACTIVITY_SYSTEM,
            'description' => $description,
        ]);
    }

    /**
     * @param Activity $activity
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Activity $activity)
    {
        return $activity->delete();
    }
}