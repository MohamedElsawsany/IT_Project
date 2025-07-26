<div class="modal fade" id="forceDeleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-forceDelete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-forceDelete">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="forceDeleteUserForm">
                <div class="modal-body">
                    Are you sure to delete <span style="color: red;" id="forceDeleteUserName"></span>?
                    <input type="hidden" id="deleteUserID">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="forceDeleteUserBtn" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
