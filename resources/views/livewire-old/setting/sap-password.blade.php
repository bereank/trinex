<div>




    <div x-data="weather()">
        <div class="modal-body">

            <div class="form-row">


                <div class="form-group col-md-12">
                    <label for>Enter You SAP Username</label>
                    <input wire:model.live="sapusername" type="text" placeholder="Sap User Name" class="form-control" />
                    @error('sapusername') <span class="text-danger">*{{ $message }}</span> @enderror

                    <br>
                    <a href="#" wire:click="resendVerification">
                        <h4> <span class="badge  mt-2 badge-success  rounded-pill d-inline">
                                Click to Verify Username
                            </span></h4>

                    </a>


                    <div wire:loading wire:target="resendVerification">
                        Verifying Username.......
                    </div>
                </div>


                <div class="form-group col-md-12">
                    <label for>Enter Verification Code Sent To your Email</label>
                    <input wire:model.live="verification" type="text" placeholder="SAP Password Reset Verirication Code"
                        class="form-control" />
                    @error('verification') <span class="text-danger">*{{ $message }}</span> @enderror


                    <br>
                    <a href="#" wire:click="verifyUserName">
                        <h4>
                            <span class="badge badge-primary rounded-pill d-inline">
                                Click to Verify Code
                            </span>
                        </h4>
                    </a>

                    <div wire:loading wire:target="verifyUserName">
                        Verifying Code.......
                    </div>


                </div>





                @if(count($databases) > 0)

                <div class="form-group col-md-12">
                    <label for>Choose Databae</label>
                    <select wire:model.blur="client_id" id="type" class="form-control">
                        <option value="">Choose Database</option>
                        @foreach ($databases as $val)
                        <option value="{{$val->id}}">{{$val->dbdetails->db_name}}</option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>



                <div class="form-group col-md-12">
                    <label for>New SAP Password</label>
                    <input wire:model.blur="SapPassword" type="password" placeholder="SAP Password"
                        class="form-control" />
                    @error('SapPassword') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>

                @endif


            </div>

        </div>
        <div class="modal-footer">
            <button @click="getWeather()" class="btn btn-primary">Submit</button>

        </div>
    </div>
    <script>
        function weather() {
                return {
                   
                    getWeather() {


                        fetch('http://192.168.1.60:8000/api/ret-sap', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                         },
                         body: JSON.stringify({ "id": 78912 })
                   })
                .then(response => response.json())
                .then(response =>  @this.alertInfo("warning",JSON.stringify(response)))
                        //  @this.alertInfo("warning","Testing info")
    
                        // console.log(@this.sapusername)
                      
                        // post('http://192.168.1.60:8000/api/ret-sap')
                        //     .then((res) => res.json())
                        //     .then((res) => {
                        //         if (!res.temperature_2m_max) {
                        //             this.error = 'Error happened when fetching the API'
                        //         } else {
                        //             this.weather = res
                        //         }
                        //         this.loading = false
                        //     })
                    }
                }
            }

            
    </script>

</div>