<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-add" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-add">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addUserForm">

                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"  id="inputGroup-sizing-default-username">User Name</span>
                        </div>
                        <input type="text" class="form-control col-xs-3" required id="user_name" name="user_name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-username" autocomplete="off">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default-email">E-mail</span>
                        </div>
                        <input type="email" class="form-control col-xs-3" required id="email" name="email" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-email" autocomplete="off">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default-password">Password</span>
                        </div>
                        <input type="password" class="form-control col-xs-3" id="password" required name="password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-password" autocomplete="off">
                    </div>

                    <select required id="user_role" style="width: 100%" name="user_role" class="custom-select form-control">
                        <option disabled value="0" selected>Select User Role</option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->role_name}}</option>
                        @endforeach

                    </select>
                    <br>
                    <br>
                    <select required id="user_site" style="width: 100%" name="user_site" class="custom-select form-control">
                        <option disabled value="0"  selected>Select Site</option>
                        @foreach($sites as $site)
                            <option value="{{$site->id}}">{{$site->site_name}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="addUserBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
