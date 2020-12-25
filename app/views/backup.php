<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Copia de Seguridad</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="border p-4">
                                    <h2 class="h4">Descargar Copia de Seguridad</h2>
                                    <div class="col-12 form-group">
                                        <small>
                                            El backup contendra la información hasta la fecha actual
                                        </small>
                                    </div>
                                    <div class="col-12 form-group">
                                        <a href="/backup/generar-backup" class="btn btn-success">
                                            Descargar Copia de Seguridad
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 d-sm-none d-block">
                                &nbsp;
                            </div>
                            <div class="col-12 col-sm-6">
                                <form method="post" enctype="multipart/form-data"
                                      class="border p-4" id="form_restaurar">
                                    <h2 class="h4">Restaurar Copia de Seguridad</h2>
                                    <div class="custom-file form-group">
                                        <input type="file" class="custom-file-input" id="file" name="file" accept=".sic115">
                                        <label class="custom-file-label" for="file"
                                               data-browse="Buscar Archivo">...</label>
                                    </div>
                                    <div class="col-12 form-group">
                                        <input type="submit" value="Restaurar Copia de Seguridad" class="btn btn-success">
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
