<div>
    <div class="modal-body">
        @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif

        @if (session()->has('messageE'))
        <div class="alert alert-danger">
            {{ session('messageE') }}
        </div>
        @endif
        <div class="row">
            <div class="col-md-8 offset-md-3">
                @if($step == 1)
                {{-- <ol class="text-left">
                    <li>Go to M-PESA on your phone</li>
                    <li>Select Pay Bill option</li>
                    <li>Enter Business no. <span style="font-size:12px; font-weight: bold;">4047541</span></li>
                    <li>Enter Account no. <span style="font-size:12px; font-weight: bold;">{{$IDNO}}</span>
                </li>
                <li>Enter the Amount. <span style="font-size:12px; font-weight: bold;">Any Amount Above 1,000</span>
                </li>
                <li>Enter your M-PESA PIN and Send</li>
                <li>You will receive a confirmation SMS from MPESA</li>
                </ol> --}}
                <button type="button" wire:click="processBilling" class="btn btn-lg btn-primary">Check Payment</button>
                <button type="button" wire:click="resendBilling" class="btn btn-lg btn-info">Resend Request</button>

                @endif
                <hr />
                <b>Email:</b> info@tuvuke.co.ke<br />
                <b>Mobile:</b> 0700679005/ 0726 399832<br />
                <hr />

            </div>
        </div>
    </div>
</div>
