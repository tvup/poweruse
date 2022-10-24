


                <!-- A grey horizontal navbar that becomes vertical on small screens -->
                <nav class="navbar navbar-expand-sm navbar-dark bg-dark justify-content-center">


                    <!-- Links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            {{link_to_route('el-meteringpoint', 'Målepunkt', [], ['class'=>'nav-link']) }}
                        </li><li class="nav-item">
                            {{link_to_route('el-charges', 'Priselementer', [], ['class'=>'nav-link']) }}
                        </li>
                        <li class="nav-item">
                            {{link_to_route('consumption', 'Forbrugsdata', [], ['class'=>'nav-link']) }}
                        </li>
                        <li class="nav-item">
                            {{link_to_route('el', 'Beregn din elregning', [], ['class'=>'nav-link']) }}
                        </li>
                        <li class="nav-item">
                            {{link_to_route('el-spotprices', 'Spotpriser', [], ['class'=>'nav-link']) }}
                        </li>
                        <li class="nav-item">
                            {{link_to_route('el-totalprices', 'Aktuelle totalpriser', [], ['class'=>'nav-link']) }}
                        </li>
                        <li class="nav-item">
                            {{link_to_route('el-custom', 'Beregn prisen for et bestemt forbrug i dag', [], ['class'=>'nav-link']) }}
                        </li>
                        <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logud</button>
                        </form>
                        </li>
                    </ul>

                </nav>