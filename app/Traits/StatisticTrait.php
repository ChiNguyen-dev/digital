<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait StatisticTrait
{
    public function statistic(string $name): object
    {
        $data = null;
        switch (Str::of($name)->upper()) {
            case "DASHBOARD":
                $data = DB::table('orders')
                    ->selectRaw(
                        'COUNT(CASE WHEN status = "1" THEN 1 END) as order_success,' .
                        'COUNT(CASE WHEN status = "0" THEN 1 END) as order_processing,' .
                        'COUNT(CASE WHEN deleted_at IS NOT NULL THEN 1 END) as order_cancel,' .
                        'SUM(CASE WHEN status = "1" AND deleted_at IS NULL THEN total ELSE 0 END ) as revenue'
                    )
                    ->first();
                break;
            case "USER":
                $data = DB::table('users')
                    ->selectRaw(
                        'COUNT(CASE WHEN deleted_at IS NOT NULL THEN 1 END) as user_cancel,' .
                        'COUNT(CASE WHEN deleted_at IS NULL THEN 1 END) as user_amount'
                    )
                    ->first();
                break;
            case "PRODUCT":
                $data = $this->queryData('products');
                break;
            case "ORDER":
                $data = $this->queryData('orders');
                break;
        }
        return $data;
    }

    public function queryData(string $table): object
    {
        $dataQuery = DB::table($table)
            ->selectRaw(
                'COUNT(CASE WHEN status = "1" THEN 1 END) as success,' .
                'COUNT(CASE WHEN deleted_at IS NOT NULL THEN 1 END) as deleted,' .
                'COUNT(CASE WHEN status = "0" THEN 1 END) as processing,' .
                'COUNT(CASE WHEN deleted_at IS NULL THEN 1 END) as quantity'
            )
            ->first();
        return (object)[
            'success' => $dataQuery->success,
            'processing' => $dataQuery->processing,
            'quantity' => $dataQuery->quantity,
            'delete' => $dataQuery->deleted,
        ];
    }
}
