<!-- Admin Header -->
<?php adminHeader($data); ?>
<!-- Admin Nav -->
<?php adminNav($data); ?>
<!-- Admin Sidebar -->
<?php adminSidebar($data); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Attendances Daily</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <form class="form-data" data-destination="attendances" calling-method="push" data-type="json">
                    <div class="form-group">
                        <label for="attendanceNote">Justificación (si llega tarde)</label>
                        <textarea class="form-control form-control-db" rows="3" placeholder="Enter ..." name="attendanceNote"
                                id="attendanceNote" <?php echo ($data["statusAttendance"] === "SUCCESS_ATTENDANCE") ? 'disabled' : ''; ?>></textarea>
                    </div>
                    <div class="form-group">
                        <label id="switch" class="switch <?php echo ($data["attendanceDaily"] === "OFF") ? 'switch-off' : 'switch-on'; ?>">
                            <input <?php echo ($data["statusAttendance"] === "SUCCESS_ATTENDANCE") ? 'disabled' : ''; ?> type="checkbox" name="switchState" value="true" <?php echo ($data["attendanceDaily"] === "ON") ? 'CHECKED' : ''; ?> />
                            <div></div>
                        </label>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">User Name</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">Start Note</th>
                        <th scope="col">End Note</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row"><?php echo $_SESSION['userData']['userName'];?></td>
                            <th><?php echo $_SESSION['userData']['profileNames'];?></th>
                            <td><?php echo $data1["attendanceStartTime"]?></td>
                            <td><?php echo $data1["attendanceEndTime"]?></td>
                            <td><?php echo $data1["attendanceStartNote"]?></td>
                            <td><?php echo $data1["attendanceEndNote"]?></td>
                        </tr>
                    </tbody>
                </table>
<!--                <div class="row">-->
<!--                    <div class="col-md-12">-->
<!--                        <div class="timeline">-->
<!--                            <div class="time-label">-->
<!--                                <span class="bg-red">10 Feb. 2014</span>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <i class="fas fa-envelope bg-blue"></i>-->
<!--                                <div class="timeline-item">-->
<!--                                    <span class="time"><i class="fas fa-clock"></i> 12:05</span>-->
<!--                                    <h3 class="timeline-header"><a href="#">@--><?php //echo $_SESSION['userData']['userName'];?><!--</a> sent you an email</h3>-->
<!---->
<!--                                    <div class="timeline-body">-->
<!--                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,-->
<!--                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity-->
<!--                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle-->
<!--                                        quora plaxo ideeli hulu weebly balihoo...-->
<!--                                    </div>-->
<!--                                    <div class="timeline-footer">-->
<!--                                        <a class="btn btn-primary btn-sm">Read more</a>-->
<!--                                        <a class="btn btn-danger btn-sm">Delete</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <i class="fas fa-clock bg-gray"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                Footer
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Admin Sidebar -->
<?php adminFooter($data); ?>
<script>
    // Selecciona el formulario y el checkbox
    const form = document.querySelector('.form-data');
    const checkbox = form.querySelector('input[type="checkbox"]');

    // Manejador para detectar el cambio en el checkbox
    checkbox.addEventListener('change', (e) => {
        // Cambiar el valor del checkbox al estado correcto antes de enviar
        checkbox.value = checkbox.checked ? "true" : "false";
        // Disparar el evento submit
        form.dispatchEvent(new Event('submit'));
    });
</script>

    <style>

        /** Switch
         -------------------------------------*/

        .switch input {
            position: absolute;
            opacity: 0;
        }

        /**
         * 1. Adjust this to size
         */

        .switch {
            display: inline-block;
            font-size: 20px; /* 1 */
            height: 1em;
            width: 2em;
            background: #BDB9A6;
            border-radius: 1em;
            cursor: pointer;
        }

        .switch div {
            height: 1em;
            width: 1em;
            border-radius: 1em;
            background: #FFF;
            box-shadow: 0 0.1em 0.3em rgba(0,0,0,0.3);
            -webkit-transition: all 300ms;
            -moz-transition: all 300ms;
            transition: all 300ms;
        }

        .switch input:checked + div {
            -webkit-transform: translate3d(100%, 0, 0);
            -moz-transform: translate3d(100%, 0, 0);
            transform: translate3d(100%, 0, 0);
        }
        .switch-on{
            background-color: #00a87d;
        }
        .switch-off{
            background-color: #df2e1b;
        }
    </style>
<script>
    const bswitch = document.querySelector("#switch");

    bswitch.addEventListener("change", function (e) {
        if (e.target.checked) {
            console.log("Encendido");
            bswitch.classList.remove("switch-off")
            bswitch.classList.add("switch-on")
        } else {
            console.log("Apagado");
            bswitch.classList.remove("switch-on")
            bswitch.classList.add("switch-off")
        }
    });
</script>