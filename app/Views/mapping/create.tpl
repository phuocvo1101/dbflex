
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add Row Mapping
                    </header>
                    <div class="panel-body">

                        <form class="form-horizontal" id="default" action="index.php?controller=mapping&action=create" method="post">

                            <div class="form-group">
                                <label class="col-lg-2 control-label">key:</label>
                                <div class="col-lg-10">
                                    <input type="text" name="key" id="key" class="form-control"  placeholder="key">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">value:</label>
                                <div class="col-lg-10">
                                    <input type="text" name="value" id="value" class="form-control"  placeholder="value">
                                </div>
                            </div>


                            <input type="submit" name="create" id="create" class="finish btn btn-danger" value="Create"/>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>