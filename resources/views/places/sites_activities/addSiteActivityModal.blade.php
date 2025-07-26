<div class="modal fade" id="addSiteActivityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-add" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-add">Add Site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addSiteActivityForm">

                <div class="modal-body">

                    <select required id="site_name" style="width: 100%;" name="site_name" class="custom-select form-control">
                        <option disabled value="0" selected>Select Site</option>
                        @foreach($sites as $site)
                            <option value="{{$site->id}}">{{$site->site_name}}</option>
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <select required id="activity_name" style="width: 100%;" name="activity_name" class="custom-select form-control">
                        <option disabled value="0" selected>Select Activity</option>
                        @foreach($activities as $activity)
                            <option value="{{$activity->id}}">{{$activity->activity_name}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="addSiteActivityBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
