@extends("layouts.app")
@section('content')

<section class="app-main__outer">
                    <section class="app-main__inner">
                      <div class="row"> <!-- row -->

                            <section class="col-md-12">       
                               <div class="card">
                                  <section class="card-header page_title"> Profile </section>
                                      <div class="card-body">
                                        <section class="text-center">
                                          <p class="text-muted">
                                            <i class="fa fa-user-circle fa-5x"></i> <br>
                                            <h4> {{ current_user()->name }} </h4>
                                          </p>
                                          <hr>

                                          <table class="table table-striped">
                                            <tbody>
                                              <tr>
                                                <th> Email </th>
                                                <td> {{ current_user()->email }} </td>
                                              </tr>
                                              <tr>
                                                <th> Role </th>
                                                <td> {{ current_user()->role->name }} </td>
                                              </tr>
                                              <tr>
                                                <th> Phone Number </th>
                                                <td> {{ current_user()->phone_number }} </td>
                                              </tr>
                                              <tr>
                                                <th> LGA/Constituency </th>
                                                <td> {{ current_user()->lga->name }} </td>
                                              </tr>

                                            </tbody>
                                          </table>

                                          <hr>

                                        <p class="text-muted"><b> Organization </b></p>
                                          <table class="table table-striped">
                                            <tbody>
                                              <tr>
                                                <th> Name </th>
                                                <td> {{ organization()->name }} </td>
                                              </tr>
                                              <tr>
                                                <th> Region </th>
                                                <td> {{ organization()->state->name }} </td>
                                              </tr>
                                              <tr>
                                                <th> Description</th>
                                                <td> {{ organization()->description }} </td>
                                              </tr>

                                            </tbody>
                                          </table>

                                        </section>

                                      </div>
                                </div>
                            </section> <!-- //col -->
                
                      </div> <!-- //row -->

                    </section>
</section>

@stop
