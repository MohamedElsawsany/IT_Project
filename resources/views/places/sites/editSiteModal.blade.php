<div class="modal fade" id="editSiteModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSiteForm">
                <input type="hidden" id="up_id">

                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"  id="inputGroup-sizing-default-upsitename">Site Name</span>
                        </div>
                        <input type="text" class="form-control col-xs-3" required id="upSiteName" name="upSiteName" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-upsitename" autocomplete="off">
                    </div>

                    <select required id="upGovernorate" style="width: 100%" name="upGovernorate" class="custom-select form-control">
                        <option disabled value="0" selected>Select User Role</option>
                        @foreach($governorates as $governorate)
                            <option value="{{$governorate->id}}">{{$governorate->governorate_name}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="updateSiteBtn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
