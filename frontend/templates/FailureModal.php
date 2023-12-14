<script>
    function throwError(Error){
        if(Error != null) {
            console.log(Error);
            document.getElementById("text-modal-error-1").innerHTML = Error;
            $('#throw-error-modal-1').modal('show');

        }
    }


</script>

<!-- Login Failure Modal -->
<div class="modal fade" id="throw-error-modal-1" tabindex="-1" role="dialog" aria-labelledby="loginFailureModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modal-header-text">
                <h5 class="modal-title" id="loginFailureModalLabel">Ocorreu um erro!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="text-modal-error-1">
                <p id="text-modal-error-p1">Invalid username or password. Please try again.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
