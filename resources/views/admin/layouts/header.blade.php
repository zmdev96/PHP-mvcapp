<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>{{@$title}}</title>
  <meta name="description" content="MVCAPP PHP Framework">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta property="og:title" content="MVCAPP PHP Framework">
  <meta property="og:image" content="/dist/dashboard/images/logo.png">
  <meta property="og:site_name" content="<?= @$this->_data['title'];?>">
  <meta property="og:description" content="MVCAPP PHP Framework">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="mvcapp">
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="apple-touch-icon" href="/dist/dashboard/images/logo.png">
  <link rel="shortcut icon" sizes="196x196" href="/dist/dashboard/images/logo.png">
  <meta http-equiv="x-pjax-version" content="v123">
  <!-- Styles -->
  <link href="{{DASHBOARD_VENDOR}}bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="{{DASHBOARD_CSS}}animate.css" rel="stylesheet" type="text/css" />
  <link href="{{DASHBOARD_VENDOR}}fontawesome/css/all.min.css" rel="stylesheet" type="text/css" />
  <link href="{{DASHBOARD_VENDOR}}nprogress/nprogress.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i'" rel="stylesheet" type="text/css" />
  @yield('content_css')
  <link href="{{DASHBOARD_CSS}}app.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
