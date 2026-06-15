@extends('layouts.master')
@section('main-content')
<div>
    <div class="mt-1">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{asset('/img/users.png')}}" alt="Admin" class="rounded-circle" width="150" />
                                <div class="mt-3">
                                    <h4>{{Auth::user()->name}}</h4>
                                    <p class="text-secondary mb-1">
                                        {{Auth::user()->email}}
                                    </p>
                                    <p class="text-muted font-size-sm">
                                        {{Auth::user()->phone_number}}
                                    </p>
                                    {{-- <p v-if="this.churches.user.twoFA === 0">
                                        <button class="btn btn-success btn-sm" @click="buySMS">
                                            Enable 2-Step Verification
                                        </button>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <h4>E-Wallet Top-Up</h4>
                                <hr>
                                <ol class="text-left">
                                    <li>Go to M-PESA on your phone</li>
                                    <li>Select Pay Bill option</li>
                                    <li>Enter Business no. <span
                                            style="font-size:12px; font-weight: bold;">4029619</span></li>
                                    <li>Enter Account no. <span style="font-size:12px; font-weight: bold;">GB211</span>
                                    </li>
                                    <li>Enter the Amount: <b>Any Amount</b></li>
                                    <li>Enter your M-PESA PIN and Send</li>
                                    <li>You will receive a confirmation SMS from MPESA</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3">
                                E-Wallet Status
                            </h6>
                            <small>Account Balance</small>
                            <div class="mb-3" style="height: 5px">
                                <div>{{Auth::user()->church->e_wallet_balance}}</div>
                            </div>
                            <small>Sms Balance</small>
                            <div class="mb-3" style="height: 5px">
                                <div>
                                    <div>{{Auth::user()->church->sms_balance}}</div>
                                </div>
                            </div>
                            <small>Load Sms</small>
                            <div class="mb-3" style="height: 4px">
                                <div>
                                    <a href="{{ route('settings.buysms') }}" class="btn btn-success btn-sm">
                                        Buy Sms
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-1">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-sm-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3">
                                Default Pricing
                            </h6>
                            <small>Standing Charge</small>
                            <div class="mb-3" style="height: 5px">
                                <div>{{$plan->StandingCharge}}</div>
                            </div>
                            <small>Price Per Unit</small>
                            <div class="mb-3" style="height: 5px">
                                <div>
                                    <div>{{$plan->UnitPrice}}</div>
                                </div>
                            </div>
                            <div class="mb-3" style="height: 4px">
                                <div>
                                    <a href="{{ route('settings.default-price') }}" class="btn btn-success btn-sm">
                                        Update the Values
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
