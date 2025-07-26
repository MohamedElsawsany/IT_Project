<div class="modal fade" id="addServerModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Server</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addServerForm">
                <div class="modal-body">
                    <table style="width:100%;" class="table table-borderless nowrap display">
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default-serverSerialNumber">Serial.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="serverSerialNumber"
                                           name="serverSerialNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-serverSerialNumber"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>

                            <td style="width:44%;margin: auto;">
                                <select required id="serverBrand" style="width: 100%" name="serverBrand"
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
                                <select required id="serverModel" style="width: 100%" name="serverModel"
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
                                <select required id="serverCPU" style="width: 100%" name="serverCPU"
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
                                <select required id="serverGPU1" style="width: 100%" name="serverGPU1"
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
                                <select id="serverGPU2" style="width: 100%" name="serverGPU2"
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
                                  id="inputGroup-sizing-default-serverHDDStorage">HDD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="serverHDDStorage"
                                           name="serverHDDStorage" aria-label="Sizing example input" value="0"
                                           aria-describedby="inputGroup-sizing-default-serverHDDStorage" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                              id="inputGroup-sizing-default-serverSSDStorage">SSD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="serverSSDStorage"
                                           name="serverSSDStorage" aria-label="Sizing example input" value="0"
                                           aria-describedby="inputGroup-sizing-default-serverSSDStorage" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                              id="inputGroup-sizing-default-serverRam">Ram</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="serverRam"
                                           name="serverRam" aria-label="Sizing example input" value="0"
                                           aria-describedby="inputGroup-sizing-default-serverRam" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <select required id="serverOS" style="width: 100%" name="serverOS"
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
                                <select required id="serverLocation" style="width: 100%" name="serverLocation"
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
                                <select required id="serverFlag" style="width: 100%" name="serverFlag"
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
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="addServerBtn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
