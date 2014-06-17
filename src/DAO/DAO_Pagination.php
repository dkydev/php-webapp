<?php

class DAO_Pagination {
	
	public function getPagedData($aParams) {
		
		$aPagedData = array();
		$aPagedData["pageNum"] = $aParams["pageNum"];
		$aPagedData["pageLimit"] = $aParams["pageLimit"];
		
		// get number of rows without pagination limits
		$sqlNoLimit = 	"SELECT COUNT(*) AS `total_rows`" . 
						" " . "FROM " . $aParams["table"] .
						" " . $aParams["join"] .
						" " . $aParams["where"] .
						" " . $aParams["groupBy"] .
						" " . $aParams["orderBy"] . ";";
		
		$sth = DB::query($sqlNoLimit, $aParams["aSQLParams"]);
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$aPagedData["totalRows"] = $row["total_rows"];
		
		
		// get rows
		$limit = "LIMIT :offset, :limit";
		$aParams["aSQLParams"][] = array(":offset", $aParams["pageLimit"] * ($aParams["pageNum"] - 1));
		$aParams["aSQLParams"][] = array(":limit", $aParams["pageLimit"]);
				
		
		$sql = 	"SELECT " 	. $aParams["select"] . 
				" " 		. "FROM " . $aParams["table"] .
				" " 		. $aParams["join"] .
				" " 		. $aParams["where"] .
				" " 		. $aParams["groupBy"] .
				" " 		. $aParams["orderBy"] .
				" " 		. $limit . ";";
		
		$sth = DB::query($sql, $aParams["aSQLParams"]);
		
		$aPagedData["rowCount"] = $sth->rowCount();
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$aPagedData["aRow"][] = $row;
		}
		
		$aPagedData["rowsAfter"] = $aPagedData["totalRows"] - $aPagedData["pageNum"] * $aPagedData["pageLimit"];
		$aPagedData["rowsBefore"] = ($aPagedData["pageNum"] - 1) * $aPagedData["pageLimit"];
		
		$aPagedData["pagesAfter"] = ceil($aPagedData["rowsAfter"] / $aPagedData["pageLimit"]);
		$aPagedData["pagesBefore"] = ceil($aPagedData["rowsBefore"] / $aPagedData["pageLimit"]);
		
		return $aPagedData;
		
	}
	
}

?>