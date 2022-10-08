<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page not found - <?=NAME_PROJECT;?></title>
    <link rel="icon" href="<?= MEDIA(); ?>images/icons/icon.ico">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
    <style>
        body {
            background: #dedede;
        }
        .page-wrap {
            min-height: 100vh;
        }
    </style>
    <div class="page-wrap d-flex flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-1 d-block text-secondary">404</span>
                <h1 class="text-secondary">OOPS! PAGE NOT BE FOUND</h1>
                <div class="mb-4 lead text-secondary">
                    Sorry, but the page you are looking for does not exist, it has been deleted, the name has been changed<br> 
                    or is temporarily unavailable  
                </div>
                <a href="<?=BASE_URL();?>" class="btn btn-link">Back to homepage</a>
            </div>
        </div>
    </div>
</div>
</body>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>