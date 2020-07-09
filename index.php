<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head><?php require_once __DIR__.'/path/head.php'; ?></head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper"><?php require_once __DIR__.'/path/navbar.php'; ?>
        <?php require_once __DIR__.'/path/sidebar.php'; ?>
       
        <div class="content-wrapper">
            <div class="content-header">
                <!-- <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div>
                    </div>
                </div> -->
            </div>

            <section class="content">
            </section>
        </div>

        <?php require_once __DIR__.'/path/footer.php'; ?>
        
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <?php require_once __DIR__.'/path/script.php'; ?>
</body>
</html>