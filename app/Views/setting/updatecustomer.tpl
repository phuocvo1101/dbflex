

<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Update Transaction
                    </header>
                    <div class="panel-body">

                        <form class="form-horizontal" id="default" action="index.php?controller=setting&action=updatecustomer" method="post">


                            <div class="form-group">
                                <label class="col-lg-2 control-label"> DBFlex Table:</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" value="{$setting->value}" id="transaction" name="transaction"  type="text" >
                                </div>
                            </div>


                            <input type="submit" name="update" id="update" class="finish btn btn-danger" value="Update"/>

                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>