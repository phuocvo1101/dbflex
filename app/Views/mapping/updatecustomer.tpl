
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Update Row Mapping
                    </header>
                    <div class="panel-body">
                        {foreach $map as $key=>$item}
                        <form class="form-horizontal" id="default" action="index.php?controller=mapping&action=updatecustomer&id={$item->id}" method="post">


                            <div class="form-group">
                                <label class="col-lg-2 control-label"> key:</label>
                                <div class="col-lg-10">
                                    <input type="text" name="key" id="key" class="form-control" value="{$item->keymap}" placeholder="mode">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">value:</label>
                                <div class="col-lg-10">
                                    <input type="text" name="value" id="value" class="form-control" value="{$item->valuemap}" placeholder="name">
                                </div>
                            </div>

                            <input type="submit" name="update" id="update" class="finish btn btn-danger" value="Update"/>
                            {/foreach}
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>