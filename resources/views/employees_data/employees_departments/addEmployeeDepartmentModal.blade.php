<div class="modal fade" id="addEmployeeDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-add" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-add">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addEmployeeDepartmentForm">

                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"  id="inputGroup-sizing-default-departmentname">Department Name</span>
                        </div>
                        <input type="text" class="form-control col-xs-3" required id="department_name" name="department_name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-departmentname" autocomplete="off">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="addEmployeeDepartmentBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
