<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css.">
    <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" type="text/css" href="../css/sb-admin-2.css">
		<!-- JQuery -->
		<script type="text/javascript" src="../js/jquery-min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login Administrator</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="../config/action.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                                </div>
                                <button name="login_adm" type="submit" class="btn btn-success pull-right">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
