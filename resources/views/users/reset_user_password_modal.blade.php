<div class="modal fade" id="resetUserPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-reset" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-reset">Reset user password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="resetUserPasswordForm">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default-resetPassword">New password</span>
                        </div>
                        <input type="password" class="form-control col-xs-3" id="resetPassword" required name="resetPassword" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-resetPassword" autocomplete="off">
                    </div>
                    <input type="hidden" id="resetUserID">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="resetPasswordBtn" class="btn btn-primary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
