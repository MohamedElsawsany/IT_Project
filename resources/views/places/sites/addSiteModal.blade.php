<div class="modal fade" id="addSiteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-add" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-add">Add Site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addSiteForm">

                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"  id="inputGroup-sizing-default-sitename">Site Name</span>
                        </div>
                        <input type="text" class="form-control col-xs-3" required id="site_name" name="site_name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-sitename" autocomplete="off">
                    </div>

                    <select required id="governorate" style="width: 100%" name="governorate" class="custom-select form-control">
                        <option disabled value="0" selected>Select Governorate</option>
                        @foreach($governorates as $governorate)
                            <option value="{{$governorate->id}}">{{$governorate->governorate_name}}</option>
                        @endforeach

                    </select>
                    <br>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="addSiteBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
