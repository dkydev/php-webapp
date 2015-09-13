<?php

class DKY_Pager
{
    /**
     * Get paginated data from a DB statement using the specified
     * 
     * @param DKY_DB_Statement $sth
     * @param unknown $aQueryParams
     * @return array Paged data array.
     */
    public static function getPagedData($sth, $page, $limit, $delta)
    {
        $aPagedData = array();
        $aPagedData["pageNum"]   = $page;
        $aPagedData["pageLimit"] = $limit;
        $aPagedData["pageDelta"] = $delta;
        
        $aStatementParams = $sth->getStatementParams();
        $query = $sth->getSelectQuery();
        // Get the total number of rows for the query.
        $queryNoLimit =  "SELECT COUNT(*) AS `total_rows` FROM (" . $query . ") AS `data`;";
        $sthNoLimit = DKY_DB::query($queryNoLimit);
        $sthNoLimit->bindParams($aStatementParams);

        $sthNoLimit->execute();
        $row = $sthNoLimit->fetch();
        $aPagedData["totalRows"] = $row["total_rows"];
        
        // Get paged rows.
        $sthPage = DKY_DB::query("SELECT * FROM ($query) AS `data` LIMIT :pager_offset, :pager_limit;");
        $sthPage->bindParams($aStatementParams);
        
        $pagerOffset = $aPagedData["pageLimit"] * ($aPagedData["pageNum"] - 1);
        $pagerLimit = $aPagedData["pageLimit"];
        $sthPage->bind("pager_offset", $pagerOffset);
        $sthPage->bind("pager_limit", $pagerLimit);
        $sthPage->execute();
        
        $aPagedData["rowCount"] = $sthPage->getRowCount();
        $aPagedData["aData"] = $sthPage->fetchAll();
        
        if (!empty($aPagedData["rowCount"])) {
            $aPagedData["totalPages"] = ceil($aPagedData["totalRows"] / $aPagedData["pageLimit"]);
        } else {
            $aPagedData["totalPages"] = 0;
        }
        
        $aPagedData["rowsAfter"]   = $aPagedData["totalRows"] - $aPagedData["pageNum"] * $aPagedData["pageLimit"];
        $aPagedData["rowsBefore"]  = ($aPagedData["pageNum"] - 1) * $aPagedData["pageLimit"];
        
        $aPagedData["pagesAfter"]  = ceil($aPagedData["rowsAfter"] / $aPagedData["pageLimit"]);
        $aPagedData["pagesBefore"] = ceil($aPagedData["rowsBefore"] / $aPagedData["pageLimit"]);
        
        return $aPagedData;
    }
}

?>