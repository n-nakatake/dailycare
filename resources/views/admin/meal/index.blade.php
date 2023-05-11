@extends('layouts.admin')
@section('title', '登録済みの食事摂取量一覧')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <h2 class="col-md-4">食事摂取量一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-12 text-end">
                <a href="{{ route('admin.meal.add', ['residentId' => $residentId]) }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <form action="{{ route('admin.meal.index', ['residentId' => $residentId]) }}" method="get">
                    <div class="form-group row">
                        <label class="w-4rem">名前</label>
                        <div class="col-md-3 ps-0">
                            <select id="residentId" class="form-control" name="resident_id">
                                @foreach($residents as $resident)
                                    <option value="{{$resident->id}}" {{ (int)$residentId === $resident->id ? 'selected' : ''}}>{{ $resident->last_name . $resident->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="w-5rem ms-5">表示月</label>
                        <div class="col-md-3 ps-0">
                            <input type="month" id="mealYm" class="form-control" name="meal_ym" value="{{ $dateYm }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="meal" class="row">
            <div class="col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="16%">日付</th>
                                <th width="28%">朝食</th>
                                <th width="28%">昼食</th>
                                <th width="28%">夕食</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datesOfMonth as $date)
                                @if (! isset($meals[$date]))
                                    <tr>
                                        <td class="align-middle ps-3">{{ formatDate($date) }}</td>
                                        <td><a href="{{ route('admin.meal.add', ['residentId' => $residentId, 'date' => $date, 'meal_bld' => 1]) }}">-</a></td>
                                        <td><a href="{{ route('admin.meal.add', ['residentId' => $residentId, 'date' => $date, 'meal_bld' => 2]) }}">-</a></td>
                                        <td><a href="{{ route('admin.meal.add', ['residentId' => $residentId, 'date' => $date, 'meal_bld' => 3]) }}">-</a></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="align-middle ps-3">{{ formatDate($date) }}</td>
                                        <td>
                                            @if (isset($meals[$date]['朝食']))
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <a href="{{ route('admin.meal.edit', ['residentId' => $meals[$date]['朝食']->resident_id, 'mealId' => $meals[$date]['朝食']->id]) }}">
                                                            主食：{{ !is_null($meals[$date]['朝食']->meal_intake_rice) ? $mealIntakeOptions[$meals[$date]['朝食']->meal_intake_rice] : '-' }}
                                                            <br>副食：{{ !is_null($meals[$date]['朝食']->meal_intake_side) ? $mealIntakeOptions[$meals[$date]['朝食']->meal_intake_side] : '-' }}
                                                            <br>汁物：{{ !is_null($meals[$date]['朝食']->meal_intake_soup) ? $mealIntakeOptions[$meals[$date]['朝食']->meal_intake_soup] : '-' }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6 middle">
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $meals[$date]['朝食']->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M6.5 1a.5.5 0 0 0-.5.5v1h4v-1a.5.5 0 0 0-.5-.5h-3ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1H3.042l.846 10.58a1 1 0 0 0 .997.92h6.23a1 1 0 0 0 .997-.92l.846-10.58Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                                            </svg>
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade text-dark" id="confirmModal{{ $meals[$date]['朝食']->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <p>{{ formatDate($date) }}の{{ $mealBldOptions[$meals[$date]['朝食']->meal_bld] }}のデータを削除してよろしいですか？</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                                        <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.meal.delete', ['residentId' => $meals[$date]['朝食']->resident_id,'mealId' => $meals[$date]['朝食']->id]) }}'">削除</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <a href="{{ route('admin.meal.add', ['residentId' => $residentId, 'date' => $date, 'meal_bld' => 1]) }}">-</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($meals[$date]['昼食']))
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <a href="{{ route('admin.meal.edit', ['residentId' => $meals[$date]['昼食']->resident_id, 'mealId' => $meals[$date]['昼食']->id]) }}">
                                                            主食：{{ !is_null($meals[$date]['昼食']->meal_intake_rice) ? $mealIntakeOptions[$meals[$date]['昼食']->meal_intake_rice] : '-' }}
                                                            <br>副食：{{ !is_null($meals[$date]['昼食']->meal_intake_side) ? $mealIntakeOptions[$meals[$date]['昼食']->meal_intake_side] : '-' }}
                                                            <br>汁物：{{ !is_null($meals[$date]['昼食']->meal_intake_soup) ? $mealIntakeOptions[$meals[$date]['昼食']->meal_intake_soup] : '-' }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6 middle">
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $meals[$date]['昼食']->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M6.5 1a.5.5 0 0 0-.5.5v1h4v-1a.5.5 0 0 0-.5-.5h-3ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1H3.042l.846 10.58a1 1 0 0 0 .997.92h6.23a1 1 0 0 0 .997-.92l.846-10.58Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                                            </svg>
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade text-dark" id="confirmModal{{ $meals[$date]['昼食']->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <p>{{ formatDate($date) }}の{{ $mealBldOptions[$meals[$date]['昼食']->meal_bld] }}のデータを削除してよろしいですか？</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                                        <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.meal.delete', ['residentId' => $meals[$date]['昼食']->resident_id,'mealId' => $meals[$date]['昼食']->id]) }}'">削除</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <a href="{{ route('admin.meal.add', ['residentId' => $residentId, 'date' => $date, 'meal_bld' => 2]) }}">-</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($meals[$date]['夕食']))
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <a href="{{ route('admin.meal.edit', ['residentId' => $meals[$date]['夕食']->resident_id, 'mealId' => $meals[$date]['夕食']->id]) }}">
                                                            主食：{{ !is_null($meals[$date]['夕食']->meal_intake_rice) ? $mealIntakeOptions[$meals[$date]['夕食']->meal_intake_rice] : '-' }}
                                                            <br>副食：{{ !is_null($meals[$date]['夕食']->meal_intake_side) ? $mealIntakeOptions[$meals[$date]['夕食']->meal_intake_side] : '-' }}
                                                            <br>汁物：{{ !is_null($meals[$date]['夕食']->meal_intake_soup) ? $mealIntakeOptions[$meals[$date]['夕食']->meal_intake_soup] : '-' }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6 middle">
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $meals[$date]['夕食']->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M6.5 1a.5.5 0 0 0-.5.5v1h4v-1a.5.5 0 0 0-.5-.5h-3ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1H3.042l.846 10.58a1 1 0 0 0 .997.92h6.23a1 1 0 0 0 .997-.92l.846-10.58Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                                            </svg>
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade text-dark" id="confirmModal{{ $meals[$date]['夕食']->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <p>{{ formatDate($date) }}の{{ $mealBldOptions[$meals[$date]['夕食']->meal_bld] }}のデータを削除してよろしいですか？</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                                        <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.meal.delete', ['residentId' => $meals[$date]['夕食']->resident_id,'mealId' => $meals[$date]['夕食']->id]) }}'">削除</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <a href="{{ route('admin.meal.add', ['residentId' => $residentId, 'date' => $date, 'meal_bld' => 3]) }}">-</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    $('input, select').change(function() {
        const indexUrl = "{{ trim(route('admin.meal.index', ['residentId' => $residentId]), '0123456789') }}";
        const residentId = $('#residentId').val();
        const mealYm = $('#mealYm').val();
        location.href= indexUrl + residentId + '?meal_ym=' + mealYm;
    });
@endsection