<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class dbclass
{
    function getResult($mqry)
    {
        //local
        $mdbname="mh";
        $mdbuser="root";
        $mdbpass="";
        $host_name="localhost";

        //server
        // $mdbname="u739226416_mh";
        // $mdbuser="u739226416_mh";
        // $mdbpass="Admin@323";
        // $host_name="localhost";

        $dbconn=mysqli_connect("localhost","$mdbuser","$mdbpass","$mdbname");
        $qry=$mqry;
        $res=mysqli_query($dbconn,$qry) or die(mysqli_error($dbconn));
        return $res;
    }

    function RunQry($mqry)
    {
        //MYSQL
        //local
        $host_name="localhost";
        $database="mh";
        $username="root";
        $password="";
        //server
        // $host_name="localhost";
        // $database="u739226416_mh";
        // $username="u739226416_mh";
        // $password="Admin@323";

        $dbconn = new PDO('mysql:host='.$host_name.';dbname='.$database, $username, $password);

        // SQL SERVER
        // $database='sofficio_'.$this->dbcid;

        // $dbconn= new PDO("sqlsrv:Server=.\SQLEXPRESS;Database=$database","","");            //office Server
        // $dbconn=new PDO("sqlsrv:Server=95.217.184.123,1434;Database=caoffice","dbadmin","Admin@323");  //for kvttechno
        // $dbconn= new PDO("sqlsrv:Server=10.1.1.11,1993;Database=sofficio","sa","Target@323");  //for sofficio own server
        
        $dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $qry=$mqry;
        $getResults=$dbconn->prepare($qry);
        $getResults->execute();
        return $getResults;
    }

    function RunQryparam($mqry,$xparam)
    {
        // //local
        $mdbname="mh";
        $mdbuser="root";
        $mdbpass="";
        $host_name="localhost";
        
        ////server
        // $mdbname="u739226416_mh";
        // $mdbuser="u739226416_mh";
        // $mdbpass="Admin@323";
        // $host_name="localhost";

        $dbconn = new PDO('mysql:host='.$host_name.';dbname='.$mdbname, $mdbuser, $mdbpass);
        $dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $qry=$mqry;
        $getResults=$dbconn->prepare($qry);
        $c=1;
        foreach($xparam as $i)
        {
            $type=gettype($i);
            if($type=='integer')
            {
                $i_type="PDO::PARAM_INT";
            }
            else if($type=='boolean')
            {
                $i_type="PDO::PARAM_BOOL";
            }
            else if($type=='string')
            {
                $i_type="PDO::PARAM_STR";
            }
            else if($type=='NULL')
            {
                $i_type="PDO::PARAM_NULL";
            }
            else if($type=='bit')
            {
                $i_type="PDO::PARAM_BIT";
            }
            else
            {
                $i_type="PDO::PARAM_STR";
            }
            $getResults->bindValue($c,$i,constant($i_type));
            $c++;
        }
        $getResults->execute();
        return $getResults;
    }

    function genID($mqry,$mpad,$xfield)
    {   
        $db=new dbclass();
        $mnewid="";
        if($res=$db->getResult($mqry))
        {
            $row=mysqli_num_rows($res);
            if($row>0)
            {	
                $mysql_row=mysqli_fetch_array($res);
                $mpkid=$mysql_row[$xfield];
                if(empty($mpkid))
                {
                    $mnewid=1;
                }
                else
                {
                    // $mpkid=substr($mpkid,4,6);
                    $mnewid=intval($mpkid)+1;
                }
            }
            else
            {
                $mnewid=1;
            }
            
            $mnewid=str_pad($mnewid,$mpad,'0',STR_PAD_LEFT);

        }
        return $mnewid;
        // return $row;
    }

    function getDocno($mqry,$mpad)
    {   
        $db=new dbclass();
        $mdocno="";
        if($res=$db->getResult($mqry))
        {
            $row=mysqli_num_rows($res);
            if($row>0)
            {	
                $mysql_row=mysqli_fetch_array($res);
                extract ($mysql_row);
                if(empty($docno))
                {
                    $mdocno=1;
                }
                else
                {
                    $mdocno=$docno+1;
                }
            }
            else
            {
                $mdocno=1;
            }
            // $mdocno=str_pad($mdocno,$mpad,'0',STR_PAD_LEFT);
        }
        return $mdocno;
    }
}

class GenDocno
{
    function genId($mqry,$mpad,$xfield,$xyymm)
    {   
        $db=new dbclass();
        $mnewid="";
        if($res=$db->getResult($mqry))
        {
            $row=mysqli_num_rows($res);
            if($row>0)
            {	
                $mysql_row=mysqli_fetch_array($res);
                $mpkid=$mysql_row[$xfield];
                if(empty($mpkid))
                {
                    $mnewid=1;
                }
                else
                {
                    // $mpkid=substr($mpkid,4,6);
                    $mnewid=intval(substr($mpkid,4,6))+1;

                }
            }
            else
            {
                $mnewid=1;
            }
            
            $mnewid=$xyymm.str_pad($mnewid,$mpad,'0',STR_PAD_LEFT);
        }
        return $mnewid;
    }
}

?>