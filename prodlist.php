<style>
    @media screen and (max-width:600px)
    {
        .tblmst
        {
        font-size: 12px;
        margin-bottom: 0;
        }
        .tblmst tr td , .tblmst tr th {
        padding:10px;
        }
    }
</style>
<?php
session_start();
include 'dbclass.php';
$db=new dbclass();
$mflg=$_POST['mmflg'];
$dflg=$_POST['mdflg'];
$mdes=$_POST['mdes'];
$qry="select * from prod where  concat(pcode,pname) like '%$mdes%' order by pcode";
if($result=$db->getResult($qry))
{
    echo "<table class='table table-condensed table-hover tblmst' >";
    echo "<thead>
            <tr>
                <th></th>
                <th>#</th>
                <th>Product ID</th>
                <th>Item Name</th>
                <th>Packets</th>
                <th>Unit</th>
                <th>Rate1</th>
                <th>Rate2</th>
                <th>Rate3</th>
            </tr>
          </thead>";
          $msrno=1;
    while($mysql_row=mysqli_fetch_array($result))
    {
        extract ($mysql_row);
        echo "<a href='#'  >
        <tr>
            <td style='width:80px;'>";
            if($mflg)
            {
                echo "<div class='fa fa-edit mstedit' onclick='shwupdt(this.id);' id='$pcode'></div>";
            }
            if($dflg)
            {
                echo "<div onclick='del(this.id);' class='fa fa-trash mstdel' id='$pcode'></div>";
            }
            echo "</td>
            <td>$msrno.</td>
            <td>$pcode</td>
            <td>$pname</td>
            <td>$unit</td>
            <td>$pkts</td>
            <td>$rate1</td>
            <td>$rate2</td>
            <td>$rate3</td>
            </tr></a>";
            $msrno++;
    }			
    echo "</table>";
}
else
{
    echo "Failed!";
}
?>
