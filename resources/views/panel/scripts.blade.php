<!-- Bootstrap and necessary plugins -->
<script src="{{ asset('fiture-style/js/jquery.min.js') }}"></script>
<script src="{{ asset('js/vendor/popper.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
<!-- <script src="{{ asset('js/vendor/pace.min.js') }}"></script> -->
<!-- Plugins and scripts required by all views -->
<!-- <script src="{{ asset('js/vendor/Chart.min.js') }}"></script> -->
<!-- CoreUI main scripts -->
<script src="{{ asset('js/app.js')}}"></script>
<script src="{{ asset('fiture-style/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('fiture-style/validation/jquery.validate.min.js') }}"></script>
<!-- Modal Popup -->
<script src="{{ asset('js/ext/modals.js')}}"></script>
<!-- Tooltip -->
<script src="{{ asset('js/ext/tooltip-convSlug.js')}}"></script>
<!-- Number Format -->
<script src="{{ asset('js/ext/number-format.js')}}"></script>
<!-- JS Validation -->
<script src="{{ asset('js/ext/js-validation.js')}}"></script>
<!-- Swal MessageBox -->
<script src="{{ asset('fiture-style/swal-msgbox/sweetalert.min.js')}}"></script>

<!-- Toastr -->
<script>
	@if(session()->has('toastr'))
		toastr.success('New {{session("toastr")}} successfully saved..', 'An {{session("toastr")}} has been created.');
	@endif
    @if(session()->has('new'))
        toastr.success('New {{session("new")}} successfully saved..', '{{session("new")}} has been created.');
	@endif
    @if(session()->has('edit'))
        toastr.success('Edit {{session("edit")}} successfully saved..', '{{session("edit")}} has been edited.');
    @endif
    @if(session()->has('delete'))
        toastr.success('Successful {{session("delete")}} deleted..', 'An {{session("delete")}} has been deleted.');
	@endif
	@if(isset($_GET['new']))
		toastr.success('New {{$_GET['new']}} successfully saved..', '{{$_GET['new']}} has been created.');
	@endif
	@if(isset($_GET['edit']))
		toastr.success('Edit {{$_GET['edit']}} successfully saved..', '{{$_GET['edit']}} has been edited.');
	@endif
	@if(Session::get('update'))
		toastr.success('Edit {{Session::get('update')}} successfully saved..', 'An {{Session::get('update')}} has been edited.');
	@endif
	@if(Session::get('dlt'))
		toastr.success('Successful {{Session::get('dlt')}} deleted..', 'An {{Session::get('dlt')}} has been deleted.');
	@endif
</script>

<!-- Remove List Datatable -->
<script>
    function removeList(elm){
        var form = $(elm.parent());
        swal({
            title: "Are you sure want to remove?",
            text: "Please make sure data you want remove..",
            buttons: true,
        }).then((confirm) => {
            if(confirm){ form.submit(); }
        });
    }
</script>

<!-- reload notification on inactive -->
<script>
    function notifB2B(response){
        response.forEach(element => {
            if(!$('.notif-'+element.div).hasClass("parent-notif")){
                var parent = $('.notif-'+element.div).parent().parent().parent().parent().find(".parent-notif");
                if(element.counter > 0){
                    parent.html('<span class="badge badge-pill badge-warning"><i class="fa fa-info"></i></span>');
                }else{
                    parent.html('');
                }
            }

            if(element.counter > 0){
                $('.notif-'+element.div).html('<span class="badge badge-pill badge-warning" style="margin-right: 15px;">'+element.counter+'</span>');
            }else{
                $('.notif-'+element.div).html('');
            }
        });
    }
    var timeoutTime = 5000;
    var timeoutTimer = setInterval(function(){ 
        $.ajax({
            url: "{{url('notif-b2b')}}",
            type: 'GET',
            success: function (response) {
                notifB2B(response);
            },
            error: function (e) {}
        });
     }, timeoutTime);
    $(document).ready(function() {
        $('body').bind('mousedown keydown', function(event) {
            clearInterval(timeoutTimer);
            timeoutTimer = setInterval(function(){ 
                $.ajax({
                    url: "{{url('notif-b2b')}}",
                    type: 'GET',
                    success: function (response) {
                        notifB2B(response);
                    },
                    error: function (e) {}
                });
             }, timeoutTime);
        });

        var returnNotif =[
            {
                "div":"cart",
                "counter":parseInt("{{Auth::user()->countCartPendingCost()}}")
            },
            {
                "div":"pending-po",
                "counter":parseInt("{{Auth::user()->countPOPending()}}")
            },
        ];
        notifB2B(returnNotif);
    });
</script>