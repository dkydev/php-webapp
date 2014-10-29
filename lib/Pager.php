<?php

class Pager 
{
    public static function getPagedData($aQueryParams) 
    {
        $aPagedData = array();
        $aPagedData["pageNum"]   = $aQueryParams["pageNum"];
        $aPagedData["pageLimit"] = $aQueryParams["pageLimit"];
        $aPagedData["pageDelta"] = $aQueryParams["pageDelta"];
        
        $sth = $aQueryParams["sth"];
        $aStatementParams = $sth->getStatementParams();
        
        // Get the query string from the statement handler.
        $query = trim($sth->getStatementHandler()->queryString);
        if (substr($query, -1) == ";") {
            $query = substr($query, 0, -1);
        }
        
        // Get the total number of rows for the query.
        $queryNoLimit =  "SELECT COUNT(*) AS `total_rows` FROM ($query) AS `data`;";
        $sthNoLimit = DB::query($queryNoLimit);
        if (!empty($aStatementParams)) {
            foreach ($aStatementParams as $aParam) {
                $sthNoLimit->bind($aParam[0], $aParam[1], $aParam[2]);
            }
        }
        $sthNoLimit->execute();
        $row = $sthNoLimit->fetch();
        $aPagedData["totalRows"] = $row["total_rows"];
        
        // Get paged rows.
        $sthPage = DB::query("SELECT * FROM ($query) AS `data` LIMIT :pager_offset, :pager_limit;");
        foreach ($aStatementParams as $aParam) {
            $sthPage->bind($aParam[0], $aParam[1], $aParam[2]);
        }
        $pagerOffset = $aQueryParams["pageLimit"] * ($aQueryParams["pageNum"] - 1);
        $pagerLimit = $aQueryParams["pageLimit"];
        $sthPage->bind("pager_offset", $pagerOffset);
        $sthPage->bind("pager_limit", $pagerLimit);        
        $sthPage->execute();
        
        $aPagedData["rowCount"] = $sthPage->getRowCount();

        $aPagedData["aData"] = array();        
        while ($aData = $sthPage->fetch()) {
            $aPagedData["aData"][] = $aData;
        }
        
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