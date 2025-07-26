<div class="modal fade" id="editServerModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Server <span id="editServerBrandName" style="color: red"></span> - <span id="editServerModelName" style="color: red"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="editServerForm">
                <div class="modal-body">
                    <table style="width:100%;" class="table table-borderless nowrap display">
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-upServerSerialNumber">Serial.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="upServerSerialNumber"
                                           name="upServerSerialNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upServerSerialNumber"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>

                            <td style="width:44%;margin: auto;">
                                <select required id="upServerBrand" style="width: 100%" name="upServerBrand"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addBrandModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 44%;margin: auto;">
                                <select required id="upServerModel" style="width: 100%" name="upServerModel"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Model</option>
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addModelModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>

                            <td style="width: 44%;margin: auto;">
                                <select required id="upServerCPU" style="width: 100%" name="upServerCPU"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select CPU</option>
                                    @foreach($cpus as $cpu)
                                        <option value="{{$cpu->id}}">{{$cpu->cpu_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addCPUModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>

                        </tr>
                        <tr>
                            <td style="width: 44%;margin: auto;">
                                <select required id="upServerGPU1" style="width: 100%" name="upServerGPU1"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Primary GPU</option>
                                    @foreach($gpus as $gpu)
                                        <option value="{{$gpu->id}}">{{$gpu->gpu_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>

                            <td style="width: 44%;margin: auto;">
                                <select id="upServerGPU2" style="width: 100%" name="upServerGPU2"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Secondary GPU</option>
                                    @foreach($gpus as $gpu)
                                        <option value="{{$gpu->id}}">{{$gpu->gpu_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addGPUModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-upServerHDDStorage">HDD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="upServerHDDStorage"
                                           name="upServerHDDStorage" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upServerHDDStorage"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-upServerSSDStorage">SSD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="upServerSSDStorage"
                                           name="upServerSSDStorage" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upServerSSDStorage"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-upServerRam">Ram</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="upServerRam"
                                           name="upServerRam" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upServerRam" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <select required id="upServerOS" style="width: 100%" name="upServerOS"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Operating System</option>
                                    @foreach($operating_systems as $operating_system)
                                        <option
                                            value="{{$operating_system->id}}">{{$operating_system->os_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addOSModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:44%;margin: auto;">
                                <select required id="upServerLocation" style="width: 100%" name="upServerLocation"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Location</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}">{{$location->activity}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <select required id="upServerFlag" style="width: 100%" name="upServerFlag"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Flag</option>
    @foreach($flags as $flag)
        @if($flag->id !== 2)
            <option value="{{$flag->id}}">{{$flag->flag_name}}</option>
        @endif
    @endforeach
                                </select>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>

                    </table>
                    <input type="hidden" id="upServerId">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="upServerBtn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

