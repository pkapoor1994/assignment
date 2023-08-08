function shwmstlist() {
    xdes = $("#lookfor").val();
    $("#lst").html("<center><i class='fas fa-sync fa-spin'></i>&nbsp;&nbsp;<b>Loading...</b></center><br/><br/>");
    xmflg = $("#mflg").val();
    xdflg = $("#mdflg").val();
    xfglc = $('#fglc').val();
    xdate1 = $('#fdate').val();
    xdate2 = $('#tdate').val();
    $.post('saledet.php', { mdes: xdes, mmflg: xmflg, mdflg: xdflg, date1: xdate1, date2: xdate2, fglc: xfglc, optn: 3 }, function (data) {
        $("#lst").html(data);
    });
}

function detaillist() {
    xdes = $("#lookfordet").val();
    $("#lstdet").html("<center><i class='fas fa-sync fa-spin'></i>&nbsp;&nbsp;<b>Loading...</b></center><br/><br/>");
    xmflg = $("#mflg").val();
    xdflg = $("#mdflg").val();
    xdate1 = $('#fdate1').val();
    xfpcode = $('#fpcode').val();
    xfglc = $('#fglc1').val();
    xdate2 = $('#tdate1').val();
    $.post('saledet.php', { mdes: xdes, mmflg: xmflg, mdflg: xdflg, date1: xdate1, date2: xdate2, fpcode: xfpcode, fglc: xfglc, optn: 6 }, function (data) {
        $("#lstdet").html(data);
    });
}

async function getform() {
    await $.post('addsale.php', {}, function (data) {
        $("#masterformdiv").html(data);
        $('.partyheader').show();
        $('.itemheader').hide();
        $('.totalheader').hide();
        $("#mglc").select2();
        $("#pglc").select2();
        fablank();
    });
    $('#actionid').html('(ADD)');
}

async function fablank() {
    await shwaddform();
    $("#tab1").html('Add');
    mdt = getdtnow();
    $('#glc').val('');
    $('#gln').val('');
    $('#gst').prop('checked',true);
    $('#docdt').val(mdt);
    $('#sdes').val('');

    $('#optn').val('1');
    $('#sttype').val('');
    $('#amount1').val('');
    $('#sgst').val('');
    $('#cgst').val('');
    $('#igst').val('');
    $('#tcsamt').val('');
    $('#misc').val('');
    $('#billamt').val('');
    $('#glc').val("").trigger('change');
    $('#pglc').val("").trigger('change');
    $('#add_items').attr('disabled', false);
    $('#warn').html('');
    salearr = [];
    gendocno();
    genvchno();
    $('#docdt').focus();
    $('.partyheader').show();
    $('.totalheader').hide();
    $('.itemheader').hide();
    $("#itembtns").hide();

    clrfilter();
    clrfilter1();
    shwmstlist();
    detaillist();
}

async function shwupdt(xrecno) {

    $('.partyheader').show();
    $('.totalheader').hide();
    $("#cancel").show();
    $("#tab1").addClass('active');
    $("#home").addClass('active');
    $("#tab2").removeClass('active');
    $("#tablisthide").removeClass('tablisthide');
    $("#view").removeClass('active');
    $('.partyheader').show();
    $('.totalheader').hide();
    $("#shw_itemheader").hide();
    $('.itemheader').show();

    arr = xrecno.split(":");
    tc = arr[0];
    ser = arr[1];
    docno = arr[2];

    $('#actionid').html('(EDIT)');
    xqry = "select * from bills where  tc='" + tc + "' and ser='" + ser + "' and docno='" + docno + "'";
    await $.post('getjsondet.php', { mqry: xqry }, function (data) {
        if (data != 0) {
            var jsonData = JSON.parse(data);
            for (var obj in jsonData) {
                if (jsonData.hasOwnProperty(obj)) {
                    for (var prop in jsonData[obj]) {
                        if (jsonData[obj].hasOwnProperty(prop)) {
                            if (prop != 'glc' && prop!='pglc' ) {
                                $("#" + prop).val(jsonData[obj][prop].trim());
                            }
                            if (prop == 'glc' || prop=='pglc') {
                                mglc=jsonData[obj]['glc'];
                                $("#" + prop).val(jsonData[obj][prop]).trigger('change');
                            }
                            
                        }
                    }
                }
            }
        }
    });


    $('#optn').val('2');

    $("#tab1").html('Update');
    $("#tab1").click();
    setTimeout(() => {
        $("#docdt").focus();
    }, 200);

    $('#docdt').focus();

    await shwupdet(xrecno);
}

async function shwupdet(xrecno) {
    arr = xrecno.split(":");
    tc = arr[0];
    ser = arr[1];
    docno = arr[2];

    xqry = "select * from sale where tc='" + tc + "' and ser='" + ser + "' and docno='" + docno + "'";
    await $.post('getjsondet.php', { mqry: xqry }, function (data1) {
        if (data1 != 0) {
            salearr = [];
            var jsonData = $.parseJSON(data1);

            for (var obj in jsonData) {
                mtrackno = Date.now();
                mtc = jsonData[obj]["tc"].trim();
                mser = jsonData[obj]["ser"].trim();
                mdocno = jsonData[obj]["docno"].trim();
                mpcode = jsonData[obj]["pcode"].trim();
                mpname = jsonData[obj]["pname"].trim();
                mlessper = jsonData[obj]["lessper"];
                mless = jsonData[obj]["less"];
                mqty = jsonData[obj]["qty"];
                mrate = jsonData[obj]["rate"];
                mamount = jsonData[obj]["amount"];
                mgamount = jsonData[obj]["gamount"];
                mtaxable = parseFloat(mgamount) - parseFloat(mless);

                mgper1 = jsonData[obj]["gper1"];
                mgper2 = jsonData[obj]["gper2"];
                mgper3 = jsonData[obj]["gper3"];
                mgstax1 = jsonData[obj]["gstax1"];
                mgstax2 = jsonData[obj]["gstax2"];
                mgstax3 = jsonData[obj]["gstax3"];
                mgsttype = jsonData[obj]["gsttype"].trim();
                mgstdes = jsonData[obj]["gstdes"].trim();
                mtrackno = jsonData[obj]["strackno"];
                msdes = jsonData[obj]["sdes"].trim();
                msttype = jsonData[obj]["sttype"].trim();
                unit = jsonData[obj]["unit"].trim();
                unid = jsonData[obj]["unid"].trim();
                brate = jsonData[obj]["brate"].trim();

                var myobj = {
                    'tc': mtc, 'ser': mser, 'docno': mdocno, 'pcode': mpcode, 'pname': mpname, 'less': mless,'lessper':mlessper,
                    'qty': mqty, 'rate': mrate, 'amount': mamount, 'gamount': mgamount, 'trackno': mtrackno, 'gper1': mgper1, 'gper2': mgper2, 'gper3': mgper3,
                    'gstax1': mgstax1, 'gstax2': mgstax2, 'gstax3': mgstax3, 'gstdes': mgstdes, 'gsttype': mgsttype, 'sdes': msdes, 
                    'sttype': msttype, 'taxable': mtaxable, 'unit': unit,'unid':unid,'brate':brate
                };
                salearr.push(myobj);
            }
        }
    });
    await getdetlist();
    await fablankdet();
}

async function adddet(xtc, xser, xdocno, xpcode, xpname, xqty, xrate, xless,xlessper, xamount, xgamount, xcount, xsdes, xsttype, xgper1, 
    xgper2, xgper3, xgstax1, xgstax2, xgstax3,
    xgstdes, xgsttype, taxable, unit,unid,brate) {
    // salearr={};
    var myobj = {
        'tc': xtc, 'ser': xser, 'docno': xdocno, 'pcode': xpcode, 'pname': xpname,
        'qty': xqty, 'rate': xrate, 'less': xless,'lessper':xlessper, 'amount': xamount, 'gamount': xgamount, 'trackno': xcount,
        'sdes': xsdes, 'sttype': xsttype, 'gper1': xgper1, 'gper2': xgper2, 'gper3': xgper3, 'gstax1': xgstax1, 'gstax2': xgstax2, 'gstax3': xgstax3,
        'gstdes': xgstdes, 'gsttype': xgsttype, 'taxable': taxable, 'unit': unit,'unid':unid,'brate':brate
    };
    salearr.push(myobj);
    await getdetlist();
    await fablankdet();
}

async function fasavedet() {
    tgper1 = $("#tgper1").val();
    tgper2 = $("#tgper2").val();
    tgper3 = $("#tgper3").val();
    tgstax1 = $("#tgstax1").val();
    tgstax2 = $("#tgstax2").val();
    tgstax3 = $("#tgstax3").val();
    tnamount = $("#tnamount").val();

    $("#gper1").val(tgper1);
    $("#gper2").val(tgper2);
    $("#gper3").val(tgper3);
    $("#gstax1").val(tgstax1);
    $("#gstax2").val(tgstax2);
    $("#gstax3").val(tgstax3);
    $("#amount").val(tnamount);

    mcount = 0; mdisper = 0;
    mtc = $('#tc').val();
    mser = $('#ser').val();
    mdocno = $('#docno').val();
    mpcode = $('#pcode').val();
    mpname = $('#pname').val();
    mqty = $('#qty').val();
    mrate = $('#rate').val();
    mbrate = $('#brate').val();
    mless = $('#less').val();
    tnamount = $("#tamount").val();
    mamount = $('#amount').val();
    mgamount = $('#gamount').val();
    mtrackno = $('#count').val();
    moptndet = $('#optndet').val();
    mgper1 = $('#gper1').val();
    mgper2 = $('#gper2').val();
    mgper3 = $('#gper3').val();
    mgstax1 = $('#gstax1').val();
    mgstax2 = $('#gstax2').val();
    mgstax3 = $('#gstax3').val();
    mgsttype = $('#gsttype').val();
    mgstdes = $('#gstdes').val();
    msttype = $('#sttype').val();
    msdes = $('#sdes').val();
    unit = $('#unit').val();
    unid = $('#unid').val();
    lessper = $('#lessper').val();

    if (moptndet == "2") {
        var idx = salearr.findIndex((row) => {
            return row.trackno == mtrackno;
        });
        if (idx >= 0) 
        {
            salearr[idx].pcode = mpcode;
            salearr[idx].pname = mpname;
            salearr[idx].qty = mqty;
            salearr[idx].rate = mrate;
            salearr[idx].count = mtrackno;
            salearr[idx].gamount = mgamount;
            salearr[idx].taxable = taxable;
            salearr[idx].amount = mamount;
            salearr[idx].gsttype = mgsttype;
            salearr[idx].gstdes = mgstdes;
            salearr[idx].gper1 = mgper1;
            salearr[idx].gper2 = mgper2;
            salearr[idx].gper3 = mgper3;
            salearr[idx].gstax1 = mgstax1;
            salearr[idx].gstax2 = mgstax2;
            salearr[idx].gstax3 = mgstax3;
            salearr[idx].sttype = msttype;
            salearr[idx].sdes = msdes;
            salearr[idx].less = mless;
            salearr[idx].lessper = mlessper;
            salearr[idx].unit = unit;
            salearr[idx].unid = unid;
            salearr[idx].brate = brate;


            await getdetlist();
            await fablankdet();
        }
    }
    else {
        count = Date.now();
        await adddet(mtc, mser, mdocno, mpcode, mpname, mqty, mrate, mless,lessper, mamount, mgamount, count, msdes, msttype, mgper1, mgper2,
            mgper3, mgstax1, mgstax2, mgstax3, mgstdes, mgsttype, taxable, unit,unid,brate);
    }
    $('#count').val("");
}

async function getdetlist() {
    datalen = Object.keys(salearr).length;
    totamt = 0; totless = 0; totgamt = 0; sgst = 0; cgst = 0; igst = 0; bqty = 0.00; tottaxable = 0.00;

    for (var obj in salearr) {
        if (salearr.hasOwnProperty(obj)) {
            tottaxable += parseFloat(salearr[obj]['taxable']);
            totamt += parseFloat(salearr[obj]['amount']);
            bqty += parseFloat(salearr[obj]['qty']);
            totless += parseFloat(salearr[obj]['less']);

            totgamt += parseFloat(salearr[obj]['gamount']);
            sgst += parseFloat(salearr[obj]['gstax1']);
            cgst += parseFloat(salearr[obj]['gstax2']);
            igst += parseFloat(salearr[obj]['gstax3']);
        }
    }
    if (totless > 0) {
        totless = totless;
    }
    else {
        totless = 0;
    }
    if (bqty > 0) {
        bqty = bqty;
    }
    else {
        bqty = 0;
    }

    if (sgst > 0) {
        sgst = sgst;
    }
    else {
        sgst = 0;
    }

    if (cgst > 0) {
        cgst = cgst;
    }
    else {
        cgst = 0;
    }

    if (igst > 0) {
        igst = igst;
    }
    else {
        igst = 0;
    }

    $('#dis').val(totless.toFixed(2));
    $('#amount1').val(totgamt.toFixed(2));
    $('#totnamt').val(totamt.toFixed(2));
    $('#tottaxable').val(tottaxable.toFixed(2));
    $('#sgst').val(sgst.toFixed(2));
    $('#cgst').val(cgst.toFixed(2));
    $('#igst').val(igst.toFixed(2));
    $('#bqty').val(bqty.toFixed(2));
    if (datalen > 0) {
        $("#itembtns").show();
        await $.post('saledet.php', { array: salearr, optn: 5}, function (data) {
            $('#itemlist').html(data);
        });
    }
    else {
        $("#itembtns").hide();

        $('#itemlist').html('');
        salearr = [];
    }
    await calcbillamt();
}

async function accchk()
{
    validacc=true;
    igst=$('#igst').val();
    sgst=$('#sgst').val();
    cgst=$('#cgst').val();
    sttype=$('#sttype').val().trim();
    if(igst>0)
    {
        if(sttype!='2G1' && sttype!='2G2')
        {
            $("#warn").addClass("danger");
            $("#warn").removeClass("success");
            $("#warn").html("You have Added Items with IGST , Can't add this party !!");
            $('#add_items').attr("disabled",true);
            validacc=false;
        }
        else
        {
            $("#warn").removeClass("danger");
            $("#warn").addClass("success");
            $("#warn").html("");
            $('#add_items').attr("disabled",false);
            validacc=true;
        }
    }
    else if((sgst+cgst)>0)
    {
        if(sttype!='1G1' && sttype!='1G2')
        {
            $("#warn").addClass("danger");
            $("#warn").removeClass("success");
            $("#warn").html("You have Added Items with SGST,CGST , Can't add this party !!");
            $('#add_items').attr("disabled",true);
            validacc=false;
        }
        else
        {
            $("#warn").removeClass("danger");
            $("#warn").addClass("success");
            $("#warn").html("");
            $('#add_items').attr("disabled",false);
            validacc=true;
        }
    }
    else
    {
        $("#warn").removeClass("danger");
        $("#warn").addClass("success");
        $("#warn").html("");
        $('#add_items').attr("disabled",false);
        validacc=true;
    }
    return validacc;
}

function getval(xval, xfield1, xfield2) {
    var str = xval.trim();
    xqry = "";
    if (xfield1 == 'glc') {
        xqry = "select * from glmast where glc='" + str + "'";
        $.post('getjsondet.php', { mqry: xqry }, function (data) {
            if (data != 0) {
                var jsonData = $.parseJSON(data);
                for (var obj in jsonData) {
                    $("#glc").val(jsonData[obj]["glc"]);
                    $("#gln").val(jsonData[obj]["gln"]);
                    $("#sdes").val(jsonData[obj]["sdes"]);
                    $("#sttype").val(jsonData[obj]["sttype"]);
                    accchk();
                }
            }
            else {
                $("#glc").val("");
                $("#gln").val("");
                $("#sdes").val("");
                $("#sttype").val("");
                accchk();

            }
        });
    }
    if (xfield1 == 'pcode') {
        xqry = "select * from prod_view where pcode='" + str + "'";
        $.post('getjsondet.php', { mqry: xqry }, async function (data) {
            if (data != 0) {
                var jsonData = $.parseJSON(data);
                for (var obj in jsonData) {
                    $("#pname").val(jsonData[obj]["pname"].trim());
                    $("#gsttype").val(jsonData[obj]["gsttype"].trim());
                    $("#gstdes").val(jsonData[obj]["gstdes"].trim());
                    $("#gper1").val(jsonData[obj]["gper1"].trim());
                    $("#gper2").val(jsonData[obj]["gper2"].trim());
                    $("#gper3").val(jsonData[obj]["gper3"].trim());
                    $("#unid").val(jsonData[obj]["unid"].trim());
                    $("#unit").val(jsonData[obj]["unit"].trim());
                    $("#qty").focus();
                    await getstk();

                }
            }
            else {
                $("#pname").val("");
                $("#gsttype").val('');
                $("#gstdes").val('');
                $("#gper1").val('');
                $("#gper2").val('');
                $("#gper3").val('');
                $("#unid").val('');
                $("#unit").val('');
            }
        });
    }
    if (xfield1 == 'pglc') {
        xqry = "select * from glmast where glc='" + str + "'";
        $.post('getjsondet.php', { mqry: xqry }, function (data) {
            if (data != 0) {
                var jsonData = $.parseJSON(data);
                for (var obj in jsonData) {
                    $("#pglc").val(jsonData[obj]["glc"]);
                    $("#pgln").val(jsonData[obj]["gln"]);
                }
            }
            else {
                $("#pglc").val("");
                $("#pgln").val("");


            }
        });
    }
}

function getstk()
{
    xdate1=$("#docdt").val();
    xdate2=$("#docdt").val();
    xpcode=$("#pcode").val();
    $.post('getstk.php',{mdate1:xdate1,mdate2:xdate2,mpcode:xpcode},function(data){
        if(data>0)
        {
            $("#warn").addClass('success');
            $("#warn").removeClass('danger');
            $("#warn").html('Current Available Stock '+ data);
            window.setTimeout(function () { $("#warn").html(""); }, 2000);

            $("#astk").val(data);

        }
        else
        {
            $("#warn").removeClass('success');
            $("#warn").addClass('danger');
            $("#warn").html('No Stock Available');
            $("#pcode").val('').trigger('change');
            window.setTimeout(function () { $("#warn").html(""); }, 2000);

        }
    })


}

function gendocno() {
    xtc = $('#tc').val();
    xser = $('#ser').val();
    xqry = "select docno from bills where tc='" + xtc + "' and ser='" + xser + "' order by convert(docno,int) desc limit 1";
    $.post('gendocno.php', { mqry: xqry, mtc: xtc, mser: xser, mpad: 0, mfield: "docno" }, function (data) {
        $('#docno').val(data);
    });
}

async function fillrecdet(xxid) {
    midlen = xxid.length;
    xid = xxid.substring(4, midlen);
    $('#optndet').val('2');

    var idx = salearr.findIndex((row) => {
        return row.trackno == xid;
    });

    if (idx >= 0) {
        for (var prop in salearr[idx]) {
            $("#" + prop).val(salearr[idx][prop]);
            if (prop == 'taxable') {
                $("#tamount").val(salearr[idx][prop]);
            }
        }

        var mtrackno = salearr[idx].trackno;
        $("#count").val(mtrackno);
    }
    mpcode = $('#pcode').val();
    $('#pcode').val(mpcode).trigger('change');

    setTimeout(() => {
        $('#pnamebtn').focus();
    }, 200);

    await calcamt();

}

async function remove(xxid) {
    midlen = xxid.length;
    xid = xxid.substring(3, midlen);

    yn = confirm("Want to Delete?")
    if (yn) {
        var idx = salearr.findIndex((row) => {
            return row.trackno == xid;
        });

        if (idx >= 0) {
            salearr.splice(idx, 1);
        }

        $('#pcode').focus();
        await fablankdet();
        await getdetlist();
    }

}

function fablankdet() {
    $('#mainbg').hide();
    $('#gstbox').hide();
    // $('#pcode').val('').trigger('change');
    $('#pcode').val('');
    $('#pname').val('');
    $('#unid').val('');
    $('#unit').val('');
    $('#qty').val('');
    $('#rate').val('');
    $('#gamount').val('');
    $('#lessper').val('');
    $('#less').val('');
    $("#warn").html("");
    $('#amount').val('');
    $('#gper1').val('');
    $('#gper2').val('');
    $('#gper3').val('');
    $('#gstax1').val('');
    $('#gstax2').val('');
    $('#gstax3').val('');
    $('#pcode').focus();
    $("#tgper1").val('');
    $("#tgper2").val('');
    $("#tgper3").val('');
    $("#tgstax1").val('');
    $("#tgstax2").val('');
    $("#tgstax3").val('');
    $("#tnamount").val('');
    $("#tamount").val('');
    $("#taxable").val('');
    $("#brate").val('');
    $('#optndet').val('1');
    getdetlist();
    setTimeout(() => {
        $('#pcode').focus();
    }, 150);
}

function chkempty() {
    var marr = { "glc": 'glc', "docdt": 'docdt'};
    noempty = true;

    for (var o in marr) {
        mmval = $("#" + o).val();
        if (empty(mmval)) {
            xid = marr[o];
            $("#" + xid).addClass("errtxt");
            noempty = false;
        }
        else {
            xid = marr[o];
            $("#" + xid).removeClass("errtxt");
        }
    }
    return noempty;
}

async function shwitemdiv() {

    if(await chkempty())
    {
        var sttype=$("#sttype").val().trim();
        if(!empty(sttype))
        {
            $("#warn").html("");
            $('.itemheader').show();
            $('#itembtns').show();
            // $('.partyheader').hide();
            fablankdet();
            $("#oflg").attr("disabled",true);
            $("#shw_itemheader").hide();
            $('#masterlist').hide();
            // $("#pcode").select2();
            setTimeout(()=>{
                $("#pnamebtn").focus(); 
            },200);   
        }
        else
        {
            $("#warn").addClass("danger");
            $("#warn").removeClass("success");
            $("#warn").html("Please Add Dealer Type in Master!");
            $("#mglc").focus();    
        }
    }
    else
    {
        $("#warn").addClass("danger");
        $("#warn").removeClass("success");
        $("#warn").html("Please Fill The Values!");
         window.setTimeout(function(){ $("#warn").html("");},2000);            
    }
}

function chkemptydet() {
    var marr = { "pcode": 'pcode', "qty": 'qty', 'rate': 'rate' };
    noempty = true;
    for (var o in marr) {
        mmval = $("#" + o).val();
        if (empty(mmval)) {
            xid = marr[o];
            $("#" + xid).addClass("errtxt");
            noempty = false;
        }
        else {
            xid = marr[o];
            $("#" + xid).removeClass("errtxt");
        }
    }
    return noempty;
}

function goback() {
    $('.itemheader').hide();
    $('.partyheader').show();
    $('#itembtns').hide();
    $('#masterlist').show();
    $('#glc').focus();
}

function nxt() {
    datalen = Object.keys(salearr).length;
    if (datalen > 0) {
        $('.partyheader').hide();
        $('.totalheader').show();
        $('#itembtns').hide();
        $('.itemheader').hide();
        $('#masterlist').hide();
        $("#tcsamt").focus();
    }
    else {
        $("#warn").addClass("danger");
            $("#warn").removeClass("success");
        $('#warn').html('Please Add Item First');
        window.setTimeout(function () { $("#warn").html(""); }, 2000);
        $("#pcode").focus();
    }

}

function totback() {
    $('.totalheader').hide();
    $('.itemheader').show();
    $('#itembtns').show();
    $('#masterlist').hide();
    $('.partyheader').show();
    $("#shw_itemheader").hide();

    $('#pcode').focus();

}

async function calcbillamt() {
    xtotnamt = $('#totnamt').val();

    if (!empty(xtotnamt)) {
        xamount1 = parseFloat(xtotnamt);
        xtotnamt = Math.round(xamount1);
    }
    else {
        xamount1 = 0.00;
        xtotnamt = 0.00;
    }

    misc = xamount1 - xtotnamt;
    // xbillamt=xtaxable-xless;
    xbillamt = xtotnamt;

    $('#misc').val(misc.toFixed(2));
    $('#billamt').val(xbillamt.toFixed(2));
}

async function save() {

    xtc = $('#tc').val();
    xser = $('#ser').val();
    xdocno = $('#docno').val();
    xdocdt = $('#docdt').val();
    xvchno = $('#vchno').val();
    xglc = $('#glc').val();
    xgln = $('#gln').val();
    xpglc = $('#pglc').val();
    xpgln = $('#pgln').val();
    xsttype = $('#sttype').val();
    xsdes = $('#sdes').val();
    xrem = $('#rem').val();
    xamount1 = $('#amount1').val();
    xdis = $('#dis').val();
    xsgst = $('#sgst').val();
    xcgst = $('#cgst').val();
    xigst = $('#igst').val();
    xtcsamt = $('#tcsamt').val();
    xmisc = $('#misc').val();
    xbillamt = $('#billamt').val();
    xbqty = $('#bqty').val();
    xoptn = $('#optn').val();
    xtrans = $('#trans').val();
    xtottaxable = $('#tottaxable').val();
    xpglc = $('#pglc').val();
    xpgln = $('#pgln').val();

    if (await chkalllength()) 
    {
        $("#savebox").show();
        $.post('saledet.php', {
            mtc: xtc, mser: xser, mdocno: xdocno, mdocdt: xdocdt,
            mglc: xglc, mgln: xgln, msttype: xsttype, msdes: xsdes,
            mpglc: xpglc, mpgln: xpgln, mrem: xrem, msalearr: salearr,trans:xtrans,
            optn: xoptn, mvchno: xvchno, mamount1: xamount1, mdis: xdis, mbillamt: xbillamt, msgst: xsgst, mcgst: xcgst,
            migst: xigst, mtcsamt: xtcsamt, mmisc: xmisc, mbqty: xbqty, tottaxable: xtottaxable,mpglc:xpglc,mpgln:xpgln
        }, function (response) {
            var resp = $.parseJSON(response);
            errsts = resp['Error'];
            errmsg = resp['ErrorMsg'];
            if (errsts == false) {
                if (errmsg == 1) {
                    $("#savebox").hide();
                    swal.fire('SAVED', '', 'success');
                    $('#masterlist').show();
                    fablank();
                    salearr = [];
                }
                else {
                    if (errmsg == 2) {
                        $("#savebox").hide();
                        swal.fire('UPDATED', '', 'success');
                        fablank();
                        salearr = [];
                    }
                    else {
                        swal.fire(errsts, '', 'error');
                    }
                }
                shwmstlist();
            }
            else {
                $("#savebox").hide();
                swal.fire(errmsg, '', 'error')
            }
        });
    }

}

function genvchno() {
    xtc = $('#tc').val();
    xser = $('#ser').val();
    xqry = "select docno from favouch where tc='" + xtc + "' and ser='" + xser + "' order by convert(docno,int) desc limit 1";
    $.post('genvchno.php', { mqry: xqry, mtc: xtc, mser: xser }, function (data) {
        $('#vchno').val(data);
    });
}

function del(xid) {
    arr = xid.split(":");
    xtc = arr[0];
    xser = arr[1];
    xdocno = arr[2];
    yn = confirm("Want to Delete? Vchno No: " + xdocno)
    if (yn) {
        $.post('saledet.php', { mtc: xtc, mser: xser, mdocno: xdocno }, function (data) {
            shwmstlist();
        });
    }

}

function checkrate() {
    var ratelist = $("#ratelst").val().trim();
    if (ratelist != '1' && ratelist != '2' && ratelist != '3') {
        $("#ratelst").val('1');
    }
}

function togglefilter() {
    $('#filter_div').toggle();
}

async function calcamt() {
    taxable = 0; taxable = 0;

    mrate =  isNaN(parseFloat($("#brate").val())) ? 0 : parseFloat($("#brate").val());
    var xsaletype = $("input[name=saletype]:checked").val();
    
    gper3 = isNaN(parseFloat($("#gper3").val())) ? 0 : parseFloat($("#gper3").val());
    mqty = isNaN(parseFloat($("#qty").val())) ? 0 : parseFloat($("#qty").val());
    mastk = isNaN(parseFloat($("#astk").val())) ? 0 : parseFloat($("#astk").val());
    mlessper = isNaN(parseFloat($("#lessper").val())) ? 0 : parseFloat($("#lessper").val());
    mless =  isNaN(parseFloat($("#less").val())) ? 0 : parseFloat($("#less").val());
        if(mqty>mastk)
        {
            $("#warn").addClass("danger");
            $("#warn").removeClass("success");
            $("#warn").html("Quantity Should Not Be Greather Than Stock ");
            window.setTimeout(function () { $("#warn").html(""); }, 2000);

            $("#qty").focus();

        }
        else
        {

        mgamount = mqty * mrate;
        if(mlessper>0)
        {
            mless=(mlessper/100)*mgamount;
            mless=mless.toFixed(2);
        }
        else
        {
            mlessper=0.00;
        }

        taxable = mgamount - mless;

        
        if (chklength('gamount')) {
            if (chklength('amount')) {
            }
        }
        else {
            $("#warn").html('');
        }


        actualrate=0.00;
            actualrate= mrate;
            $("#rate").val(actualrate);
        mgamount=0.00;
        if(actualrate>0)
        {
            mgamount = mqty * actualrate;
            if(mlessper>0)
            {
                mless=(mlessper/100)*mgamount;
                mless=mless.toFixed(2);
            }
            else
            {
                mlessper=0.00;
            }
            taxable = mgamount - mless;    
        }
            
    }
 
    $('#gamount').val(mgamount.toFixed(2));
    $('#amount').val(taxable.toFixed(2));
    $('#tamount').val(taxable.toFixed(2));
    $('#less').val(mless);

}

function percheck()
{
    mlessper = isNaN(parseFloat($("#lessper").val())) ? 0 : parseFloat($("#lessper").val());

    if(mlessper>0)
    {
        calcamt();
        if(mlessper>100)
        {
            $("#warn").addClass("danger");
            $("#warn").removeClass("success");
            $("#warn").html("Less% can't be greater than 100");
            $("#lessper").focus();

            return false;
        }
        else 
        {
            $("#warn").html("");
            return true;
        }
    }
    else if(mlessper<0)
    {
        calcamt();
        $("#warn").addClass("danger");
        $("#warn").removeClass("success");
        $("#warn").html("Less% can't be less than 0");
        $("#lessper").focus();
        return false;
    }
    else
    {
        return true;
    }
}

function lesscheck()
{
    less=isNaN(parseFloat($("#less").val())) ? 0 : parseFloat($("#less").val());
    if(less>0)
    {
        $("#lessper").val(0.00);
    }
}

async function addgst() {
    if (chkemptydet()) {
        if(await percheck())
        {
            $('#mainbg').show();
            xtaxable = $("#amount").val();
            xgper1 = $("#gper1").val();
            xgper2 = $("#gper2").val();
            xgper3 = $("#gper3").val();
            xsttype = $("#sttype").val();
            var xsaletype = $("input[name=saletype]:checked").val();
            if (await chklength('gamount') && await chklength('amount')) {
                $("#warn").html("");
                await $.post('gstbox.php', {taxable: xtaxable, gper1: xgper1, gper2: xgper2, 
                    gper3: xgper3, sttype: xsttype,saletype:xsaletype }, function (gsdata) {
                    $('#mainbg').html(gsdata);

                    $("#taxable").val(xtaxable);
                    $("#tgper1").val(xgper1);
                    $("#tgper2").val(xgper2);
                    $("#tgper3").val(xgper3);
                    caltotal();
                    $('#gstbox').show();
                    $('#gst_save').focus();
                });
            }
        }
    }
    else {
        $("#warn").addClass("danger");
        $("#warn").removeClass("success");
        $("#warn").html("Please Fill The Values!");
        window.setTimeout(function () { $("#warn").html(""); }, 2000);
        $("#pcode").focus();
    }
}

async function chklength(xid) {
    var xxid = xid;
    var xid = '#' + xid;
    var xval = isNaN(parseInt($(xid).val())) ? 0 : parseInt($(xid).val());
    if (xval!=0) {
        
        if (xval >99999999) {
            $('#warn').removeClass("success");
            $('#warn').addClass("warn");
            $("#warn").html('Amount Value must be less than 8 digits!');
            // $('#qty').focus();
            $("#errtxt").val(false);
            return false;
        }
        else {
            $('#warn').removeClass("errtxt");
            $("#warn").html('');
            return true;
        }
    }
}

async function chkalllength() {
    var marr = { 'bqty': "bqty", 'sgst': "sgst", 'cgst': "cgst", 'igst': "igst", 'billamt': 'billamt', 'misc': "misc", 'dis': "dis" };
    noempty = true;
    for (var o in marr) {
        mmval = isNaN(parseInt($("#" + o).val())) ? 0 : parseInt($("#" + o).val());

        if (mmval != 0) {
            // var vallen = parseInt(mmval.length);
            if (mmval > 99999999) {
                $('#warn').removeClass("success");
                $('#warn').addClass("warn");
                $('#' + o).addClass("errtxt");
                $("#warn").html('Amount Value must be less than 8 digits!');
                $('#qty').focus();
                $("#errtxt").val(false);
                return false;
            }
            else {
                $('#' + o).removeClass("errtxt");
                $('#warn').removeClass("errtxt");
                $("#warn").html('');
            }
        }
    }
    return noempty;
}

function delrec(xid) {
    $("#warn").removeClass("success");

    arr = xid.split(":");
    xtc = arr[0];
    xser = arr[1];
    xdocno = arr[2];
    yn = confirm("Want to Delete? Serial No: " + xdocno)
    if (yn) {
        $.post('saledet.php', { mtc: xtc, mser: xser, mdocno: xdocno, optn: 4 }, function (data) {
            if (data == '1') {
                $("#warn").addClass("danger");
                $("#warn").removeClass("suceess");
                $("#warn").html("Deleted");
                fablank();

                window.setTimeout(function () { $("#warn").html(""); }, 2000);
            }

            shwmstlist();
        });
    }
}

function clrfilter() {
    mdt = getdtnow();
    $('#fdate').val($("#Pfdate").val());
    $('#tdate').val(mdt);
    $('#fglc').val('').trigger('change');
    shwmstlist();
}

function clrfilter1() {
    mdt = getdtnow();
    $('#fdate1').val($("#Pfdate").val());
    $('#fglc1').val('').trigger('change');
    $('#fpcode').val('').trigger('change');
    $('#tdate2').val(mdt);
    detaillist();
}

function cancelsave() {
    $('#warn').html('');
    $("#shw_itemheader").show();
    fablankdet();
    fablank();
}

tab1.addEventListener("click", function () {
    moptn = $("#optn").val();
    if (moptn == "1") {
        setTimeout(() => {
            $('#docdt').focus();
        }, 150);
        gendocno();
    }
});

function shwfilter() {
    $('#filter').toggle();
}

function shwfilter1() {
    $('#filter1').toggle();
}



function shwaddform()
{
    xaflg=$("#maflg").val();
    if(xaflg=='1')
    {
        $("#tab1").addClass('active');
        $("#home").addClass('active');
        $("#tab2").removeClass('active');
        $("#view").removeClass('active');
        $("#tablisthide").removeClass('tablisthide');
    }
    else
    {
        $("#tab1").removeClass('active');
        $("#home").removeClass('active');
        $("#tab2").addClass('active');
        $("#view").addClass('active');
        $("#tablisthide").addClass('tablisthide');
    }
}

function enbl()
{
    var xcrtype = $("input[name=crtype]:checked").val();
    if(xcrtype=='CASH')
    {   
        $("#mglc").val("CASH").trigger('change');
        $("#mglc").attr("disabled",true);
    }
    if(xcrtype=='CREDIT')
    {
        $("#mglc").val("").trigger('change');
        $("#mglc").attr("disabled",false);
    }
}

function ledger()
{
    if(chkglc())
    {
        $("#dwld").html('');

        $('#ledgerdet').html("<center><i class='fas fa-sync fa-spin'></i>&nbsp;&nbsp;<b>Loading...</b></center><br/><br/>");
        xdes=$('#lookfor').val();
        xdate1=$('#fdate2').val();
        xdate2=$('#tdate2').val();
        xglc=$('#fglc2').val();
        $.post('ledgerdet.php',{mdes:xdes,mdate1:xdate1,mdate2:xdate2,mglc:xglc},function(data){
            //alert(data);
            $('#ledgerdet').html(data);
        });
    }
    else
    {
        $('#warn').html('Please Select Account!');
    }
}

function chkglc()
{
    var glc=$('#fglc2').val();
    if(empty(glc))
    {
        $("#warn").addClass('warn');
        $("#warn").removeClass('success');
        $('#warn').html('Please Select Account!');
        return false;
    }
    else
    {
        $('#warn').html('');
        return true;
    }
}

function shwfilter2()
{
    $('#filtr2').toggle();
    $('#ledgerdet').toggleClass('forheight');
}

function clrfilter2()
{
    mdt = getdtnow();
    $('#fdate2').val($("#Pfdate").val());
    $('#fglc2').val('').trigger('change');
    $('#ledgerdet').html('');

    $('#tdate2').val(mdt);
    // ledger();
}

function ledgerpopup()
{
    glc=$("#glc").val();
    gln=$("#gln").val();
    if(!empty(glc))
    {
        $('#contbox').show();
        $('#contboxcont').html('');
        $.post('shwledger.php',{mglc:glc,mgln:gln
        },function (data){
            $('#contboxcont').html(data);
        });
    }	
    else
    {
        $("#warn").addClass('warn');
        $("#warn").removeClass('success');
        $('#warn').html('Please Select Account!');
    }
}