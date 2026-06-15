<div>
    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="card bg-primary">
                <div class="card-header border-0">
                    <h3 class="card-title">Approval Summary</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>All Approval Requests </th>
                                <th>Total Approved</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($authUserDatabases as $item)
                            <tr>
                                <td>
                                    {{$item->dbdetails->db_name}}
                                    
                                </td>
                                <td> {{$item['approvalrequests']}}</td>
                                <td>
                                    {{-- <small class="text-success mr-1">
                                <i class="fas fa-arrow-up"></i>
                                12%
                            </small> --}}
                                    {{$item['totalApproved']}}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

  
    </div>
</div>
