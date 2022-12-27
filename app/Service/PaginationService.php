<?php

namespace App\Service;

class PaginationService
{
    public static function makePagination($eloquent, $showCount)
    {
        $resultShowCount = 1;
        if (is_numeric($showCount) && $showCount > 0) $resultShowCount = $showCount; else{
            $resultShowCount = count($eloquent->get());
        }
        $paginationResult =$eloquent->paginate($resultShowCount)->toArray();
        $result['result'] = $paginationResult['data'];
        $result['all_count'] = $paginationResult['total'];
        return $result;

    }
}
