<div class="modal fade" id="editEmployeeDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEmployeeDepartmentForm">
                <input type="hidden" id="up_id">

                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"  id="inputGroup-sizing-default-upemployeedepartmentname">Department Name</span>
                        </div>
                        <input type="text" class="form-control col-xs-3" required id="upEmployeeDepartmentName" name="upEmployeeDepartmentName" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-upemployeedepartmentname" autocomplete="off">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="updateEmployeeDepartmentBtn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
