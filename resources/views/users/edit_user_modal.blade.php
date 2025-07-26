<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editUserForm">
                <input type="hidden" id="up_id">

                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"  id="inputGroup-sizing-default-upusername">User Name</span>
                        </div>
                        <input type="text" class="form-control col-xs-3" required id="upUsername" name="upUsername" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-upusername" autocomplete="off">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default-upemail">E-mail</span>
                        </div>
                        <input type="email" class="form-control col-xs-3" required id="upEmail" name="upEmail" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-upemail" autocomplete="off">
                    </div>

                    <select required id="upUserRole" style="width: 100%" name="upUserRole" class="custom-select form-control">
                        <option disabled value="0" selected>Select User Role</option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->role_name}}</option>
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <select required id="upUserSite" style="width: 100%" name="upUserSite" class="custom-select form-control">
                        <option disabled value="0"  selected>Select Site</option>
                        @foreach($sites as $site)
                            <option value="{{$site->id}}">{{$site->site_name}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="updateUserBtn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
