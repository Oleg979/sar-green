<?php
function constructFilterQueryForFlowerGardens($filters) {
    $sql = 'select * from "flowergardensalldata" where "flowerGardensId" in (select "flowerGardensId" from "flowerGardens" where 1 = 1 ';
    
    writeToServerLog(json_encode($filters));

    // Фильтр по номеру участка
    $siteNumber = $filters['siteNumber'];
    if(count($siteNumber) > 0) {
        $sql = $sql.'and "siteNumber" in (';
        foreach ($siteNumber as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по главному объекту
    $mainObjectId = $filters['mainObjectId'];
    if(count($mainObjectId) > 0) {
        $sql = $sql.'and "mainObjecstId" in (';
        foreach ($mainObjectId as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по жизненному состоянию
    $statuses = $filters['flowerGardenLifeStatusCategoryId'];
    if(count($statuses) > 0) {
        $sql = $sql.'and "flowerGardenLifeStatusCategoryId" in (';
        foreach ($statuses as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по типу покрытия
    $statuses = $filters['flowerGardenGrassingTypeId'];
    if(count($statuses) > 0) {
        $sql = $sql.'and "flowerGardenGrassingTypeId" in (';
        foreach ($statuses as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по типу насаждения
    $statuses = $filters['flowerGardenTypeId'];
    if(count($statuses) > 0) {
        $sql = $sql.'and "flowerGardenTypeId" in (';
        foreach ($statuses as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по площади
    $area_from = $filters['area_from'];
    $area_to = $filters['area_to'];

    if(strlen($area_from) > 0) {
        $sql = $sql.'and ';
        if(strlen($area_to) > 0) {
            $sql = $sql.'"areaVal" between '.$area_from.' and '.$area_to.' ';
        } else {
            $sql = $sql.'"areaVal" >= '.$area_from.' ';
        }
    } 
    else if(strlen($area_to) > 0) {
        $sql = $sql.'and ';
        if(strlen($area_from) > 0) {
            $sql = $sql.'"areaVal" between '.$area_from.' and '.$area_to.' ';
        } else {
            $sql = $sql.'"areaVal" <= '.$area_to.' ';
        }
    }

    // Фильтр по дате инвентаризации
    $date_from = $filters['date_from'];
    $date_to = $filters['date_to'];

    if(strlen($date_from) > 0) {
        $sql = $sql.'and ';
        if(strlen($date_to) > 0) {
            $sql = $sql.'"date" between TO_DATE('."'".$date_from."', 'DD/MM/YYYY') AND TO_DATE('".$date_to."', 'DD/MM/YYYY') ";
        } else {
            $sql = $sql.'"date" >= TO_DATE('."'".$date_from."', 'DD/MM/YYYY') ";
        }
    } 
    else if(strlen($date_to) > 0) {
        $sql = $sql.'and ';
        if(strlen($date_from) > 0) {
            $sql = $sql.'"date" between TO_DATE('."'".$date_from."', 'DD/MM/YYYY') AND TO_DATE('".$date_to."', 'DD/MM/YYYY') ";
        } else {
            $sql = $sql.'"date" <= TO_DATE('."'".$date_to."', 'DD/MM/YYYY') ";
        }
    }

    // Фильтр по составу
    $compositeElements = $filters['composite'];
    if($compositeElements != "null" and count($compositeElements) > 0) {
        $sql = $sql.'and (1 = 0 ';
        foreach ($compositeElements as $value) {
            $sql = $sql.'or "flowersGardensComposit" @> ARRAY['.$value.']::integer[] ';
        }
        $sql = $sql.")";
    }

    // Фильтр по районам
    $districts = $filters['districtId'];
    if(count($districts) > 0) {
        $sql = $sql.') AND "districtId" in (';
        foreach ($districts as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    } else {
        $sql = $sql.')';
    }
        
    $sql = $sql.' ORDER BY "mainObjecstId", "siteNumber";';

    return $sql;
}

function constructFilterQueryForTrees($filters) {
    $sql = 'select * from "treesandshrubsalldata" where "treesAndShrubsId" in (select "treesAndShrubsId" from "treesAndShrubs" where 1 = 1 ';
    
    writeToServerLog(json_encode($filters));

    // Фильтр по  текущему возрасту
    $age_from = $filters['currentAge_from'];
    $age_to = $filters['currentAge_to'];

    if(strlen($age_from) > 0) {
        $sql = $sql.'and ';
        if(strlen($age_to) > 0) {
            $sql = $sql.'"currentAge" between '.$age_from.' and '.$age_to.' ';
        } else {
            $sql = $sql.'"currentAge" >= '.$age_from.' ';
        }
    } 
    else if(strlen($age_to) > 0) {
        $sql = $sql.'and ';
        if(strlen($age_from) > 0) {
            $sql = $sql.'"currentAge" between '.$age_from.' and '.$age_to.' ';
        } else {
            $sql = $sql.'"currentAge" <= '.$age_to.' ';
        }
    }

    // Фильтр по возрасту посадки
    $landingAge_from = $filters['landingAge_from'];
    $landingAge_to = $filters['landingAge_to'];

    if(strlen($landingAge_from) > 0) {
        $sql = $sql.'and ';
        if(strlen($landingAge_to) > 0) {
            $sql = $sql.'"landingAge" between '.$landingAge_from.' and '.$landingAge_to.' ';
        } else {
            $sql = $sql.'"landingAge" >= '.$landingAge_from.' ';
        }
    } 
    else if(strlen($landingAge_to) > 0) {
        $sql = $sql.'and ';
        if(strlen($landingAge_from) > 0) {
            $sql = $sql.'"landingAge" between '.$landingAge_from.' and '.$landingAge_to.' ';
        } else {
            $sql = $sql.'"landingAge" <= '.$landingAge_to.' ';
        }
    }

    // Фильтр по высоте
    $heigth_from = $filters['heig_from'];
    $heigth_to = $filters['heig_to'];

    if(strlen($heigth_from) > 0) {
        $sql = $sql.'and ';
        if(strlen($heigth_to) > 0) {
            $sql = $sql.'"height" between '.$heigth_from.' and '.$heigth_to.' ';
        } else {
            $sql = $sql.'"height" >= '.$heigth_from.' ';
        }
    } 
    else if(strlen($heigth_to) > 0) {
        $sql = $sql.'and ';
        if(strlen($heigth_from) > 0) {
            $sql = $sql.'"height" between '.$heigth_from.' and '.$heigth_to.' ';
        } else {
            $sql = $sql.'"height" <= '.$heigth_to.' ';
        }
    }

    // Фильтр по диаметру
    $diametr_from = $filters['diameterAtHeight13_from'];
    $diametr_to = $filters['diameterAtHeight13_to'];

    if(strlen($diametr_from) > 0) {
        $sql = $sql.'and ';
        if(strlen($diametr_to) > 0) {
            $sql = $sql.'"diameterAtHeight13" between '.$diametr_from.' and '.$diametr_to.' ';
        } else {
            $sql = $sql.'"diameterAtHeight13" >= '.$diametr_from.' ';
        }
    } 
    else if(strlen($diametr_to) > 0) {
        $sql = $sql.'and ';
        if(strlen($diametr_from) > 0) {
            $sql = $sql.'"diameterAtHeight13" between '.$diametr_from.' and '.$diametr_to.' ';
        } else {
            $sql = $sql.'"diameterAtHeight13" <= '.$diametr_to.' ';
        }
    }

    // Фильтр по дате посадки
    $landing_from = $filters['landingDate_from'];
    $landing_to = $filters['landingDate_to'];

    if(strlen($landing_from) > 0) {
        $sql = $sql.'and ';
        if(strlen($landing_to) > 0) {
            $sql = $sql.'"landingDate" between TO_DATE('."'".$landing_from."', 'DD/MM/YYYY') AND TO_DATE('".$landing_to."', 'DD/MM/YYYY') ";
        } else {
            $sql = $sql.'"landingDate" >= TO_DATE('."'".$landing_from."', 'DD/MM/YYYY') ";
        }
    } 
    else if(strlen($landing_to) > 0) {
        $sql = $sql.'and ';
        if(strlen($landing_from) > 0) {
            $sql = $sql.'"landingDate" between TO_DATE('."'".$landing_from."', 'DD/MM/YYYY') AND TO_DATE('".$landing_to."', 'DD/MM/YYYY') ";
        } else {
            $sql = $sql.'"landingDate" <= TO_DATE('."'".$landing_to."', 'DD/MM/YYYY') ";
        }
    }

    // Фильтр по дате изобретения
    $invent_from = $filters['inventDate_from'];
    $invent_to = $filters['inventDate_to'];

    if(strlen($invent_from) > 0) {
        $sql = $sql.'and ';
        if(strlen($invent_to) > 0) {
            $sql = $sql.'"inventDate" between TO_DATE('."'".$invent_from."', 'DD/MM/YYYY') AND TO_DATE('".$invent_to."', 'DD/MM/YYYY') ";
        } else {
            $sql = $sql.'"inventDate" >= TO_DATE('."'".$invent_from."', 'DD/MM/YYYY') ";
        }
    } 
    else if(strlen($invent_to) > 0) {
        $sql = $sql.'and ';
        if(strlen($invent_from) > 0) {
            $sql = $sql.'"inventDate" between TO_DATE('."'".$invent_from."', 'DD/MM/YYYY') AND TO_DATE('".$invent_to."', 'DD/MM/YYYY') ";
        } else {
            $sql = $sql.'"inventDate" <= TO_DATE('."'".$invent_to."', 'DD/MM/YYYY') ";
        }
    }

    // Фильтр по породам
    $species = $filters['specieId'];
    if(count($species) > 0) {
        $sql = $sql.'and "specieId" in (';
        foreach ($species as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по рекомендацям
    $recommend = $filters['recommend'];
    if(count($recommend) > 0) {
        $sql = $sql.'and "recommendationId" in (';
        foreach ($recommend as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по номеру участка
    $siteNumber = $filters['siteNumber'];
    if(count($siteNumber) > 0) {
        $sql = $sql.'and "siteNumber" in (';
        foreach ($siteNumber as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по главному объекту
    $mainObjectId = $filters['mainObjectId'];
    if(count($mainObjectId) > 0) {
        $sql = $sql.'and "mainObjectId" in (';
        foreach ($mainObjectId as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по типам насаждений
    $types = $filters['plantingType'];
    if(count($types) > 0) {
        $sql = $sql.'and "plantingType" in (';
        foreach ($types as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по жизненному состоянию
    $statuses = $filters['treeOrShrubLifeStatusCategoryId'];
    if(count($statuses) > 0) {
        $sql = $sql.'and "treeOrShrubLifeStatusCategoryId" in (';
        foreach ($statuses as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по жизненным формам
    $forms = $filters['lifeFormId'];
    if(count($forms) > 0) {
        $sql = $sql.'and "lifeFormId" in (';
        foreach ($forms as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    }

    // Фильтр по районам
    $districts = $filters['districtId'];
    if(count($districts) > 0) {
        $sql = $sql.') AND "districtId" in (';
        foreach ($districts as $value) {
            $sql = $sql."'".$value."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql.') ';
    } else {
        $sql = $sql.")";
    }
        
    $sql = $sql.' ORDER BY "mainObjectId", "siteNumber", "plantNumber";';    
    
    return $sql;
}