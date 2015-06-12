<script type="text/javascript">
    function answers()
    {
        var selectedanswer=document.getElementById("recordlimit").value;
        var frm = document.getElementById("frm");
        frm.action = "index.php?controller=report&action=index&limit="+selectedanswer;
        frm.submit();
    }
</script>
<form id="frm" action="index.php?controller=report&action=index" method="post">
    <section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                      
                        <div class="panel-body">
                            <form role="form" class="form-horizontal tasi-form">
                                Settings
                            </form>
                            {if !empty($message) && $message!=''}
                                <div style="color:red;">{$message}</div>
                            {/if}
                            {if !empty($result)}
                                {if $result==0}
                                    <div style="color:red;">Update settings was failed</div>
                                {else}
                                    <div style="color:green;">Update settings was successfull</div>
                                {/if}
                            {/if}
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Form Settings
                        </header>
                        <div class="panel-body">
                            <div class=" form">
                                <form class="cmxform form-horizontal tasi-form" id="settingForm" method="post" action="index.php?controller=setting&action=index" novalidate="novalidate">
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-2">DBFlex User</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" value="{if !empty($settings.dbflex_user)}{$settings.dbflex_user}{/if}" id="dbflex_user" name="dbflex_user"  type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-lg-2">DBFlex Password</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " value="{if !empty($settings.dbflex_pass)}{$settings.dbflex_pass}{/if}" id="dbflex_pass" type="text" name="dbflex_pass" required="">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-2">DBFlex Domain:</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " value="{if !empty($settings.dbflex_url)}{$settings.dbflex_url}{/if}" id="dbflex_url" type="text" name="dbflex_url">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-2">Eway Key</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" value="{if !empty($settings.eway_key)}{$settings.eway_key}{/if}" id="eway_key" name="eway_key"  type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-lg-2">Eway Password</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " value="{if !empty($settings.eway_pass)}{$settings.eway_pass}{/if}" id="eway_pass" type="text" name="eway_pass" required="">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-2">Eway Enviroment:</label>
                                        <div class="col-lg-10">
                                            <select id="eway_envir" name="eway_envir"  class="form-control input-lg m-bot15">
                                                <option {if !empty($settings.eway_envir) && $settings.eway_envir=="1"}selected="selected"{/if} value="1">Sandbox</option>
                                                <option {if  empty($settings.eway_envir) || (!empty($settings.eway_envir) && $settings.eway_envir=="0")}selected="selected"{/if} value="0">Live</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-2">Eway APP ID:</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " value="{if $settings.eway_appid}{$settings.eway_appid}{/if}"  id="eway_appid" type="text" name="eway_appid">
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-2">Cronjob Interval Time:</label>
                                        <div class="col-lg-10">
                                            <select id="cronjob_interval" name="cronjob_interval"  class="form-control input-lg m-bot15">
                                                {foreach array(1,5,10,15,20,30,60,90) as $item}
                                                    <option value="{$item}">{$item} Minute</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-2">Factor:</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " value="{if $settings.factor}{$settings.factor}{/if}"  id="factor" type="text" name="factor">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-danger" name="subFormSetting" id="subFormSetting" type="submit">Save</button>
                                            <button class="btn btn-default" onclick="location.reload();" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </section>
                </div>
            </div>

            <!-- page end-->
        </section>
    </section>
</form>