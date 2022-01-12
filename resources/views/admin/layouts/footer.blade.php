</div>
</div>
<!-- End Page Content-->
<!-- Start of Option Box -->
<div class="option-box">
  <a class="option-switcher" href="#"><span><i class="fa fa-cog " aria-hidden="true"></i></span></a>
  <div class="box-header d-flex justify-content-center align-items-center">
    <h5>Options Box</h5>
  </div>
  <hr class="header-row">
  <div class="box-content">
    google
  </div>
</div>
<!-- End of Option Box -->
<!-- Start Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Click "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger" href="{{$this->url('app-admin/auth/logout')}}">Logout</a>
      </div>
    </div>
  </div>
</div>
<!-- End Logout Modal-->

</div>
</div>

<!--Footer Resources-->
<script src="{{DASHBOARD_VENDOR}}jquery/jquery3.4.1.min.js" type="text/javascript"></script>
<script src="{{DASHBOARD_VENDOR}}bootstrap/bootstrap.min.js" type="text/javascript"></script>
<script src="{{DASHBOARD_VENDOR}}jquery-nicescroll/jquery.nicescroll.min.js" type="text/javascript"></script>
<script src="{{DASHBOARD_JS}}helper.js" type="text/javascript"></script>
<script src="{{DASHBOARD_VENDOR}}nprogress/nprogress.js" type="text/javascript"></script>
{{-- <script src="{{DASHBOARD_VENDOR}}pjax/jquery.pjax.js" type="text/javascript" ></script>
<script src="{{DASHBOARD_JS}}pages/pjax.min.js" type="text/javascript" ></script> --}}
@yield('content_js')
<script src="{{DASHBOARD_JS}}app.min.js" type="text/javascript"></script>
<?php $this->unserFooter() ?>
<!-- _
       .__(.)< (Zeyad Moslem)
        \___)
 ~~~~~~~~~~~~~~~~~~-->
</body>
</html>
