<div class="modal fade" id="addModelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-add">Add New Model</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addModelForm">

                <div class="modal-body">
                    <select required id="modelBrand" style="width: 100%" name="modelBrand"
                            class="custom-select form-control">
                        <option disabled value="0" selected>Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"  id="inputGroup-sizing-default-model">Model Name</span>
                        </div>
                        <input type="text" class="form-control col-xs-3" required id="modelName" name="modelName" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default-model" autocomplete="off">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="addModelBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
