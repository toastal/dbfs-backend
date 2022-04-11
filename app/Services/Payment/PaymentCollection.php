<?php
/**
 * Created by PhpStorm.
 * User: Murali
 * Date: 04/11/2022
 * Time: 11:57 PM
 */

namespace App\Services\Payment;

use App\Models\Payments;

/**
 * Class PaymentCollection
 * @package App\Services\Payment
 */
class PaymentCollection
{
    /**
     * @var array
     */
    public $meta = [];

    /**
     * @var mixed
     */
    public $builder;
    /**
     * @var int
     */
    protected $per_page = 30;

    public function __construct(Payments $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this
            ->start()
            ->byUser()
            ->byQuery()
            ->end()
            ->paginate($this->getLimit());

    }

    /**
     * @return mixed
     */
    public function start()
    {
        $this->builder = $this->model
            ->orderBy('created_at', 'DESC')
            ->with('user');

        return $this;
    }

    /**
     * @return mixed
     */
    public function end()
    {
        return $this->builder;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @return $this
     */
    public function byUser()
    {
        if (request()->has('user_id') && request()->get('user_id')) {
            $this->builder = $this->builder->where('user_id', request()->get('user_id'));
            $this->meta['user_id'] = request()->get('user_id');
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function byQuery()
    {
        if (request()->has('q') && request()->get('q')) {
            $keyword = '%' . request()->get('q') . '%';
            $this->builder = $this->builder->where('user.name', 'like', $keyword);
            $this->meta['q'] = request()->get('q');
        }

        return $this;
    }    

    /**
     * @return mixed
     */
    public function getLimit()
    {
        $limit = request()->get('per_page', $this->per_page);

        return $limit;
    }
}