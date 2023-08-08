<?php
	session_start();
    include "dbclass.php";
    $db=new dbclass();
    $cyymm=$_SESSION['yymm'];
?>

<form action="" method="post" id="saleform">
    <input type="hidden" class="form-control txtbox" value="1" id="optn" name="optn"/>
    <input type="hidden" class="form-control txtbox" value="1" id="vchno" name="vchno"/>
    <input type="hidden" class="form-control txtbox" value="1" id="optndet" name="optndet"/>
    <input type="hidden" class="form-control txtbox" value="S11" id="tc" name="tc"/>
    <input type="hidden" class="form-control txtbox" value="<?php echo $cyymm;?>" id="ser" name="ser"/>
    <input type="hidden" class="form-control txtbox" style="padding:4px;"  value='0' id="count" name="count" data-name="docno"  maxlength="8" />

    <div class='row'>
        <div class='col-sm-6'>
            <div class='partyheader' style='display:none'>
                <div class='leftcol'>
                    <table class='formtable' width='100%'>
                        <tr>
                            <td>S No:</td>
                            <td>
                                <input type="text" class="form-control txtbox" style="padding:4px;"  value="" id="docno" name="docno"  readonly
                                data-name="docno"  maxlength="8" />
                            </td>
                            <td class='starclass'>Date:</td>
                            <td>
                                <input type="date" class="form-control txtbox" style="padding:4px;" 
                                value="" id="docdt" name="docdt"
                                tabindex="1" data-name="Date"  />
                            </td>
                        </tr>
                        <tr>
                            <td class='starclass'>Customer</td>
                            <td colspan='3'>
                                <select name='glc' id='glc' class='form-control' style='width:100%' tabindex="4" onChange="getval(this.value,'glc','gln');">
                                    <?php
                                        $qry="select * from glmast order by gln";
                                        $result=$db->getResult($qry);
                                        echo "<option value=''>--Select Account--</option>";
                                        while($data=mysqli_fetch_array($result))
                                        {
                                            extract($data);
                                            $glc=trim($glc);
                                            $gln=trim($gln);
                                            echo "<option  value='$glc'>$gln</option>";
                                        }
                                        ?>
                                </select>
                                <input type="hidden" name="gln" id="gln" value=''/>
                            </td>
                        </tr>
                        <tr>
                            <td class='starclass'>Purchaser </td>
                            <td colspan='3'>
                                <select name='pglc' id='pglc' class='form-control' style='width:100%' tabindex="4" onChange="getval(this.value,'pglc','pgln');">
                                    <?php
                                        $qry="select * from glmast order by gln";
                                        $result=$db->getResult($qry);
                                        echo "<option value=''>--Select Account--</option>";
                                        while($data=mysqli_fetch_array($result))
                                        {
                                            extract($data);
                                            $glc=trim($glc);
                                            $gln=trim($gln);
                                            echo "<option  value='$glc'>$gln</option>";
                                        }
                                        ?>
                                </select>
                                <input type="hidden" name="pgln" id="pgln" value=''/>
                            </td>
                        </tr>

                        <tr>
                            <td>Dealer Type</td>
                            <td colspan='3'>
                                <input type="text" class="form-control txtbox" style="padding:4px;" name="sdes" id="sdes" value='' readonly />
                            </td>
                        </tr>
                    </table>
                </div>
            </div> 
        </div>

        <div class='partyheader tocenter' id='shw_itemheader'>
            <input type='button' class='btn btn-primary' value='Add Items' id='add_items' style='width:100px;margin-right:5px;margin-bottom: 5px;' 
            tabindex="13" onclick='shwitemdiv()'/>
            <input type='button' class='btn btn-warning' value='Cancel' style='width:100px;margin-right:5px;margin-bottom: 5px;' 
            id='cancel' onclick='cancelsave()' tabindex='14'/>
            <?php //include "exitbtn.php"; ?>
        </div>


    </div>

    <!-- item header -->
  

    <div class='itemheader' style='display:none'>
        <div class='row'>
            <div class='col form-group' style='margin-bottom:0;'>
                <div class='row'>
                    <div class='col mycol' style="max-width:230px;">
                        <div class='form-group'>
                            <label for='pcode'>Item</label><br>
                            <select name='pcode' id='pcode' class='form-control txtbox' onChange="getval(this.value,'pcode','pname');" 
                            tabindex="13" >
                                    <?php
                                        $qry="select * from prod order by pname ";
                                        $result=$db->getResult($qry);
                                        echo "<option value=''>--Select Product Name--</option>";
                                        while($data=mysqli_fetch_array($result))
                                        {
                                            extract($data);
                                            $pcode=trim($pcode);
                                            echo "<option value='$pcode'>$pname</option>";
                                        }
                                    ?>
                            </select>
                            <input type="hidden" class="form-control txtbox" value="" id="pname" name="pname">
                            <input type="text" class="form-control txtbox" value="" id="astk" name="astk">
                        </div>
                    </div>

                    <div class='col' style="max-width:90px;">
                        <div class='form-group'>
                            <label for='unit'>Unit</label>
                            <input type="text" class="form-control txtbox " style="padding:4px;width:88px;"  value="" id="unit" readonly name="unit" 
                            oninput='isnum(this.id);' maxlength='6' onblur='calcamt();' />
                            <input type="hidden" class="form-control txtbox" style="padding:4px;"  value="" id="unid" name="unid">

                        </div>
                    </div>
                    <div class='col' style="max-width:90px;">
                        <div class='form-group'>
                            <label for='qty'>Quantity</label>
                            <input type="text" class="form-control txtbox toright" style="padding:4px;width:88px;"  value="" id="qty" name="qty" tabindex="14" 
                            oninput='isnum(this.id);' maxlength='6' onblur='calcamt();' />
                        </div>
                    </div>
                    <div class='col mycol' style="max-width:130px;text-align:right">
                        <div class='form-group'>
                            <label for='rate'>Rate</label>
                            <input type="text" class="form-control txtbox toright" style="padding:4px;width:128px;"
                              value="" id="brate" name="brate"  tabindex="15" 
                            oninput='isnum(this.id);' maxlength='6' onblur='calcamt();'
                            data-name="docno" />   
                            <input type="hidden" class="form-control txtbox toright" style="padding:4px;width:128px;"  value="" id="rate" name="rate"  tabindex="15" 
                            oninput='isnum(this.id);' maxlength='6' onblur='calcamt();'
                            data-name="docno" />          
                        </div>
                    </div>
                    <div class='col mycol' style="max-width:150px;text-align:right">
                        <div class='form-group'>
                            <label for='gamount'>Amount</label>
                            <input type="text" class="form-control txtbox toright" style="padding:4px;width:148px;" value="" id="gamount" name="gamount"
                                readonly data-name="Date" />
                        </div>
                    </div>
                    <div class='col' style="max-width:110px;text-align:right">
                        <div class='form-group'>
                            <label for='lessper'>Less%</label>  
                            <input type="text" class="form-control txtbox toright" style="padding:4px;width:100px;"  value="" id="lessper" name="lessper"  tabindex="16" 
                            oninput='isnum(this.id);' maxlength='6' onblur='percheck();'
                            data-name="repname"  />
                        </div>
                    </div>
                    <div class='col' style="max-width:130px;text-align:right">
                        <div class='form-group'>
                            <label for='less'>Less</label>  
                            <input type="text" class="form-control txtbox toright" style="padding:4px;width:128px;"  value="" id="less" name="less"  tabindex="16" 
                            oninput='isnum(this.id);' maxlength='6' onchange='lesscheck();' onblur='calcamt();'
                            data-name="repname"  />
                        </div>
                    </div>
                    <div class='col' style="max-width:200px;text-align:right">
                        <div class='form-group'>
                            <label for='docdt'>Taxable Amount</label>
                            <input type="text" class="form-control txtbox toright" style="padding:4px;width:200px;" id="tamount" name="tamount"
                                readonly />
                        </div>
                    </div>
                    <div class='col-sm -2'>
                        <div class='form-group'>
                            <input type="hidden" id='dumpid' name='dumpid' value=''>
                            <input type="hidden" id='dumpdes' name='dumpdes' value=''>
                            <input type="hidden" id='stc' name='stc' value=''>
                            <input type="hidden" id='sser' name='sser' value=''>
                            <input type="hidden" id='sdocno' name='sdocno' value=''>
                            <input type="hidden" id='sqty' name='sqty' value=''>
                            <input type="hidden" id='gper1' name='gper1' value=''>
                            <input type="hidden" id='gper2' name='gper2' value=''>
                            <input type="hidden" id='gper3' name='gper3' value=''>
                            <input type="hidden" id='gstax1' name='gstax1' value=''>
                            <input type="hidden" id='gstax2' name='gstax2' value=''>
                            <input type="hidden" id='gstax3' name='gstax3' value=''>
                            <input type="hidden" id='gstdes' name='gstdes' value=''>
                            <input type="hidden" id='gsttype' name='gsttype' value=''>
                            <input type="hidden" id='amount' name='amount' value=''>
                            <input type="hidden" id='sttype' name='sttype' value=''>
                            <input type='button' class='btn btn-success' value='Add' style='width:100px;margin-top:30px;margin-left:10px;'
                             onclick='addgst();' tabindex='17'/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id='itemlist'>
        </div>
        <!--END OF ROW-->
    </div>
    <div id='itembtns' style='display:none;' >
        <!-- <input type='button' class='btn btn-danger totop' style="position:relative;width:100px;" value="Go Back" onclick='goback();' /> -->
        <input type='button' class='btn btn-primary totop' style="position:relative;width:100px;margin-right:20px;" value="Next" onclick='nxt();' />
        <input type='button' class='btn btn-warning' value='Cancel' style='width:100px;margin-right:5px;margin-bottom: 5px;' 
        id='cancel' onclick='cancelsave()' tabindex='14'/>
    </div>

    <div class='row totalheader' style='display:none'>
        <div class='form-group'>
            <table class='formtable' width='100%'>
              
                <tr>
                    <td colspan='2'><label>Gross Amount</label></td>
                    <td colspan='2'>
                        <input type='text' class='form-control txtbox toright' value='' id='amount1' name='amount1' readonly/>
                        <input type='hidden' class='form-control txtbox toright' value='' id='bqty' name='bqty' readonly/>                            
                        <input type="hidden" id='totnamt' name='totnamt' value=''>
                    </td>
                </tr>
                <tr>
                    <td><label>Discount</label></td>
                    <td></td>

                    <td colspan='2'><input type='text' class='form-control txtbox toright' value='' name='dis' id='dis' readonly onblur='calcbillamt();'/></td>

                </tr>
                <tr>
                    <td colspan='2'><label>Taxable Amount</label></td>
                    <td colspan='2'><input type='text' class='form-control txtbox toright' value='' name='tottaxable' id='tottaxable' readonly onblur='calcbillamt();'/></td>

                </tr>
                <tr>
                    <td colspan='2'><label>S.G.S.T.</label></td>
                    <td colspan='2'><input type='text' class='form-control txtbox toright' value='' name='sgst' id='sgst' readonly/></td>
                </tr>
                <tr>
                    <td colspan='2'><label>C.G.S.T.</label></td>
                    <td colspan='2'><input type='text' class='form-control txtbox toright' value='' name='cgst' id='cgst' readonly/></td>
                </tr>
                <tr>
                    <td colspan='2'><label>I.G.S.T.</label></td>
                    <td colspan='2'><input type='text' class='form-control txtbox toright' value='' name='igst' id='igst' readonly/></td>
                </tr>
                <tr>
                    <td colspan='2'><label>TCS Amount</label></td>
                    <td colspan='2'><input type='text' class='form-control txtbox toright' value='' maxlength='6' name='tcsamt' id='tcsamt' /></td>
                </tr>
                <tr>
                    <td colspan='2'><label>RoundOff</label></td>
                    <td colspan='2'><input type='text' class='form-control txtbox toright' value='' name='misc' id='misc' readonly/></td>
                </tr>
                <tr>
                    <td colspan='2'><label>Bill Amount</label></td>
                    <td colspan='2'><input type='text' class='form-control txtbox toright' value='' name='billamt' id='billamt' readonly/></td>
                </tr>
                <tr>
                    <td colspan='4'><input type='button' class='btn btn-danger' style='float:right;' value='Go Back' onclick='totback()'/></td>
                </tr>
                <tr>
                    <td colspan='4'><input type='button' class='btn btn-success' style='width:100%' value='SAVE' onclick='save()'/></td>
                </tr>
                
            </table>
        </div>
    </div>
</form>