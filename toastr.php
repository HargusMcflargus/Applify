<link rel="stylesheet" href="/APLIFY/assets/css/toastr.css">
<script src="/APLIFY/assets/js/toastr.js"></script>

<?php
    echo "
        <script>
            toastr.options = {
                'closeButton': false,
                'debug': false,
                'newestOnTop': false,
                'progressBar': true,
                'positionClass': 'toast-top-right',
                'preventDuplicates': true,
                'onclick': null,
                'showDuration': '300',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut'
            }
        </script>

    ";
    if(isset($_SESSION['toaster_Success'])){
        echo "
            <script>
                toastr.success('". $_SESSION['toaster_Success'] ."');
                toastr.options.timeOut = 3000;
            </script>
        
        ";
        unset($_SESSION['toaster_Success']);
    }
    else if(isset($_SESSION['toaster_Error'])){
        echo "
            <script>
                toastr.error('". $_SESSION['toaster_Error'] ."');
                toastr.options.timeOut = 3000;
            </script>
        
        ";
        unset($_SESSION['toaster_Error']);
    }
?>