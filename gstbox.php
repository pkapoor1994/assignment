<?php
date_default_timezone_set("Asia/kolkata");
$currdate=date('Y-m-d');

// $taxable=$_POST['taxable'];
// $gper1=$_POST['gper1'];
// $gper2=$_POST['gper2'];
// $gper3=$_POST['gper3'];
$saletype=$_POST['saletype'];
$sttype=$_POST['sttype'];

// $namount=0.00;
// $mtax=0.00;

$g1='readonly';
$g2='readonly';
$g3='readonly';
// if(trim($sttype=='1G1') || trim($sttype=='1G2'))
// {
//     // $gstax1=number_format($taxable*($gper1/100),2);//sgst
//     // $gstax2=number_format($taxable*($gper2/100));//cgst
//     // $gstax3=0.00;
//     // $gper3=0.00;
//     $g3='readonly';
// }
// if(trim($sttype=='2G1') || trim($sttype=='2G2'))
// {
//     // $gper1=0.00;
//     // $gper2=0.00;
//     // $gstax1=0.00;//igst
//     // $gstax2=0.00;//igst
//     // $gstax3=number_format($taxable*($gper3/100),2);//igst
//     $g2='readonly';
//     $g1='readonly';

// }

// $mtax=$gstax1+$gstax2+$gstax3;
// $namount=$taxable+$mtax;

?>
<style>
    .gstbox_boxbg
    {
        width:100%;
        height:100%;
        position:fixed;
        left:0px;
        top:0;
        clear:both;
        background-color:black;
        opacity:0.3;
        z-index:24;
    }
    .gstbox_div
    {
        width:400px;
        /* min-height: 400px; */
        height:auto;
        position:fixed;
        top:25%;
        padding:0px;
        border-radius:5px;
        z-index:25;
        background-color:white;
        border-radius: 10px;
        left:40%;
    }
    .darkclosebtn {
        font-size: 20px;
        color: white;
        float: right;
        font-weight: 200;
        background-color: transparent;
        border: none;
        outline: none;
        padding-right: 10px;
    }
  
    @media screen and (max-width: 800px) 
    {
        .gstbox_div
        {
            display: block;
            height:auto;
            left:5%;
            right:5%;
            width:90%;
        }
    };
</style>

<script>

    $(document).ready(function(){
        caltotal();
    });

    function hidebox()
    {
        $('#gstbox').hide();
        $('#mainbg').hide();
    }

    async function caltotal()
    {
        namount=0.00;
        xgper1=0;xgper2=0;xgper3=0;
        xsttype=$("#sttype").val().trim();
        var xsaletype = $("input[name=saletype]:checked").val();

        taxable=isNaN(parseFloat($("#taxable").val()))? 0:parseFloat($("#taxable").val());

        if(xsttype=='1G1' || xsttype=='1G2' || xsttype=='2G1' || xsttype=='2G2')
        {
            xgper1= isNaN(parseFloat($("#tgper1").val()))?0.00:parseFloat($("#tgper1").val());
            xgper2=isNaN(parseFloat($("#tgper2").val()))? 0:parseFloat($("#tgper2").val());
            xgper3=isNaN(parseFloat($("#tgper3").val()))? 0:parseFloat($("#tgper3").val());
        }
        gstax1=0.00;gstax2=0.00;gstax3=0.00;
       

        if(xsttype=='1G1' || xsttype=='1G2')
        {
            gstax1=parseFloat(taxable)*(parseFloat(xgper1)/100);//sgst
            gstax2=parseFloat(taxable)*(parseFloat(xgper2)/100);//cgst
            gstax3=0.00;
            xgper3=0.00;
        }
        if(xsttype=='2G1' || xsttype=='2G2')
        {
            xgper1=0.00;
            xgper2=0.00;
            gstax1=0.00;//igst
            gstax2=0.00;//igst
            gstax3=parseFloat(taxable)*(parseFloat(xgper3)/100);//igst
        }
        mtax=gstax1+gstax2+gstax3;
        namount=parseFloat(taxable)+mtax;
        $("#tgper1").val(xgper1);
        $("#tgper2").val(xgper2);
        $("#tgper3").val(xgper3);
        $("#tgstax1").val(gstax1.toFixed(2));
        $("#tgstax2").val(gstax2.toFixed(2));
        $("#tgstax3").val(gstax3.toFixed(2));
        $("#tnamount").val(namount.toFixed(2));
    
    }

</script>

<div class="gstbox" id='gstbox'>
    <div class='gstbox_boxbg' onclick='hidebox();'></div>
    <div class='gstbox_div ' id='gstbox_div'>
        <div class='frmtitlebar'>GST Details											
            <button type="button"  class='darkclosebtn'  onclick="hidebox();" data-toggle='tooltip'  title='Close' 
                data-original-title='Close' data-placement='bottom'>X
            </button>
        </div>
        <div clas='masterform'>
            <div class='masterent'>
                <form  id="gsform">
                    <table width='100%'>
                        <tr>
                            <td style="padding:5px;">
                            <label for='taxable'>Taxable:</label>
                            <td style="padding:5px;">
                            <td style="padding:5px;">
                                <input type="text" class="form-control toright" style='width:170px;float:right;' maxlength='7' id="taxable"  
                                oninput='isnum(this.id);' name="taxable" readonly  /> 
                        </tr>
                        <tr>
                            <td style="padding:5px;">
                            <label for='tgper1'>S.G.S.T:</label>
                            <td style="padding:5px;">
                                <input type="text" class="form-control toright" style='width:70px;float:right;' maxlength='7' id="tgper1" <?php echo $g1 ?> 
                                oninput='isnum(this.id);caltotal();' name="tgper1"  tabindex="1" />    

                            <td style="padding:5px;">
                                <input type="text" class="form-control toright" style='width:170px;float:right;' maxlength='7' id="tgstax1"  
                                oninput='isnum(this.id);' readonly name="tgstax1"  /> 
                        </tr>
                        <tr>
                            <td style="padding:5px;">
                            <label for='tgper1'>C.G.S.T:</label>
                            <td style="padding:5px;">
                                <input type="text" class="form-control toright" style='width:70px;float:right;' maxlength='7' id="tgper2" <?php echo $g2; ?>  
                                oninput='isnum(this.id);caltotal();' name="tgper2"  tabindex="2" /> 
                            <td style="padding:5px;">
                                <input type="text" class="form-control toright" style='width:170px;float:right;' maxlength='7' id="tgstax2" 
                                oninput='isnum(this.id);' readonly name="tgstax2" /> 
                        </tr>
                        <tr>
                            <td style="padding:5px;">
                            <label for='tgper1'>I.G.S.T:</label>
                            <td style="padding:5px;">
                                <input type="text" class="form-control toright" style='width:70px;float:right;' maxlength='7' id="tgper3" <?php echo $g3; ?> 
                                oninput='isnum(this.id);caltotal();' name="tgper3" tabindex="3" /> 
                            <td style="padding:5px;">
                                <input type="text" class="form-control toright" style='width:170px;float:right;' maxlength='7' id="tgstax3"
                                oninput='isnum(this.id);' readonly name="tgstax3" /> 
                        </tr>
                        <tr>
                            <td style="padding:5px;">
                            <label for='tnamount'>Net Amount:</label>
                            <td style="padding:5px;">
                            <td style="padding:5px;">
                                <input type="text" class="form-control toright" style='width:170px;float:right;' maxlength='7' id="tnamount" 
                                 name="tnamount" readonly /> 
                        </tr>
                        <tr>
                            <td style="padding:5px;">
                            <td style="padding:5px;">
                            <td style="padding:5px;" class='toright'>
                                <button type='button' class='btn btn-success' id='gst_save' tabindex='4' onclick='fasavedet();'>Save</button>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>