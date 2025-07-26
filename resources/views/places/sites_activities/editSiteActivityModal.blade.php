<div class="modal fade" id="editSiteActivityModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSiteActivityForm">
                <input type="hidden" id="up_id">

                <div class="modal-body">
                    <select required id="upSiteName" style="width: 100%;" name="upSiteName" class="custom-select form-control">
                        <option disabled value="0" selected>Select Site</option>
                        @foreach($sites as $site)
                            <option value="{{$site->id}}">{{$site->site_name}}</option>
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <select required id="upActivityName" style="width: 100%;" name="upActivityName" class="custom-select form-control">
                        <option disabled value="0" selected>Select Activity</option>
                        @foreach($activities as $activity)
                            <option value="{{$activity->id}}">{{$activity->activity_name}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="updateSiteActivityBtn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
