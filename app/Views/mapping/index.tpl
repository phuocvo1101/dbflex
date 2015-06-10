
<form id="frm" action="index.php?controller=mapping&action=index" method="post">
    <section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6 col-sm-9 placeholder">
                                    <h3 align="left"><span> Mappings</span></h3>
                                </div>
                                <div class=" col-xs-6 col-sm-2">
                                    <a class="btn btn-primary" href="index.php?controller=mapping&action=create">Add Row</a>

                                </div>

                            </div>
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