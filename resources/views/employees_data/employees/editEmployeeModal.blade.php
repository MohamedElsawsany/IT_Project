<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEmployeeForm">
                <input type="hidden" id="up_id">

                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"  id="inputGroup-sizing-default-upEmployeeName">Employee Name</span>
                        </div>
                        <input type="text" class="form-control col-xs-3" required id="upEmployeeName" name="upEmployeeName" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-upEmployeeName" autocomplete="off">
                    </div>

                    <select required id="upDepartmentName" style="width: 100%;" name="upDepartmentName"
                            class="custom-select form-control">
                        <option disabled value="0" selected>Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->department_name}}</option>
                        @endforeach
                    </select>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="updateEmployeeBtn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
