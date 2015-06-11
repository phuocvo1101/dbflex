
<form id="frm" action="index.php?controller=setting&action=update" method="post">
    <section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <div class="row panel-heading">
                                <div class="col-xs-6 col-sm-9 placeholder">
                                    <h3 align="left"><span> Mappings</span></h3>
                                </div>
                                <div class=" col-xs-6 col-sm-2">
                                    <a class="btn btn-primary" href="index.php?controller=mapping&action=create">Add Row</a>

                                </div>

                            </div>
                            <form action="index.php?controller=setting&action=update" method="post">
                            <div class="row ">
                                <label for="cname" class="control-label col-lg-2">DBFlex Table:</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" value="{$setting->value}" id="transaction" name="transaction" readonly   type="text" >
                                </div>
                                <div class="col-lg-3">
                                    <a class="btn btn-info" href="index.php?controller=setting&action=update">Edit DBFlex</a>
                                </div>
                            </div>
                                </form>

                        </header>


                        <div class="panel-body">
                            <section id="unseen">

                                <table class="table table-bordered table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>key</th>
                                        <th>value</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    {if isset($maps)}
                                        {foreach $maps as $key=>$item}
                                            <tr>
                                                <td>{$item->keymap}</td>
                                                <td>{$item->valuemap}</td>

                                                <td><a href="index.php?controller=mapping&action=update&id={$item->id}" class="btn btn-success">Edit</a>
                                                    <span>|</span>
                                                    <a href="index.php?controller=mapping&action=delete&id={$item->id}" class="btn btn-info">Delete</a>
                                                </td>


                                            </tr>
                                        {/foreach}
                                    {/if}

                                    </tbody>

                                </table>
                            </section>
                        </div>
                    </section>
                </div>
            </div>

            <!-- page end-->
        </section>
    </section>
</form>