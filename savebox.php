<style>
    #savebox{
        display:none;
    }
    #saveboxcont{
        width:350px;
        height:250px;
        border:1px solid lightgray;
        background-color:white;
        border-radius:2px;
        text-align:center;
        position:fixed;
        z-index:99999;
        left:40%;
        top:30%;
        box-shadow:1px 1px 25px 1px lightgray;
    }
    #saveboxcont h4{
        padding-top:25%;
    }
    #saveboxbg{
        width:100%;
        height:100%;
        position:fixed;
        z-index:9999;
        top:0px;
        left:0px;
        clear:both;
        background-color:black;
        opacity:0.5;
    }
    #savegif{
        width:50px;
        height:50px;
    }
    @media screen and (max-width:800px) {

        #saveboxcont{
            width:200px;
            height:250px;
            border:1px solid lightgray;
            background-color:white;
            border-radius:2px;
            text-align:center;
            position:fixed;
            z-index:99999;
            left:30%;
            top:40%;
            box-shadow:1px 1px 25px 1px lightgray;
        }
        #saveboxcont h4{
            font-size:20px;
            margin:5px;
        }
        #savegif{
            width:55px;
            height:55px;
        }

    }
</style>
<div id='savebox'>
    <div id='saveboxbg'></div>
    <div id="saveboxcont" >
        <h4>Loading.........</h4><br/>
        <img src='bloader.gif' id='savegif' />
    </div>
</div>