@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection
@section('style')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            -webkit-tap-highlight-color: transparent;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
@endsection

@section('content')
    <div
        class="relative flex min-h-screen w-full flex-col max-w-[430px] mx-auto bg-white dark:bg-background-dark shadow-2xl overflow-x-hidden">
        <header
            class="sticky top-0 z-10 flex items-center bg-white/80 dark:bg-background-dark/80 backdrop-blur-md px-4 py-4 border-b border-gray-100 dark:border-white/10 justify-between">
           <a href="{{ route('user.index') }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                    <span class="material-symbols-outlined text-black dark:text-white">
                        arrow_back_ios_new
                    </span>
                </div>
            </a>
            <h2 class="text-[#181111] dark:text-white text-lg font-bold leading-tight tracking-tight flex-1 text-center">
                Transaction History</h2>
            <div class="size-10 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#181111] dark:text-white">search</span>
            </div>
        </header>

        <nav class="flex gap-3 p-4 overflow-x-auto no-scrollbar scroll-smooth">
            <div class="filter-btn flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-primary px-6 transition-colors cursor-pointer" data-filter="all">
                <p class="text-white text-sm font-semibold leading-normal">All</p>
            </div>
            <div class="filter-btn flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-gray-100 dark:bg-white/5 px-6 transition-colors cursor-pointer" data-filter="sent">
                <p class="text-[#181111] dark:text-white text-sm font-medium leading-normal">Transfer</p>
            </div>
            <div class="filter-btn flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-gray-100 dark:bg-white/5 px-6 transition-colors cursor-pointer" data-filter="received">
                <p class="text-[#181111] dark:text-white text-sm font-medium leading-normal">Deposit</p>
            </div>
            <div class="filter-btn flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-gray-100 dark:bg-white/5 px-6 transition-colors cursor-pointer" data-filter="pending">
                <p class="text-[#181111] dark:text-white text-sm font-medium leading-normal">Pending</p>
            </div>
            <div class="filter-btn flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-gray-100 dark:bg-white/5 px-6 transition-colors cursor-pointer" data-filter="success">
                <p class="text-[#181111] dark:text-white text-sm font-medium leading-normal">Success</p>
            </div>
            <div class="filter-btn flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-gray-100 dark:bg-white/5 px-6 transition-colors cursor-pointer" data-filter="failed">
                <p class="text-[#181111] dark:text-white text-sm font-medium leading-normal">Rejected</p>
            </div>
        </nav>

        <main class="flex flex-col flex-1 pb-20">
          @forelse($transactions as $date => $items)

              <div class="px-4 pt-4 pb-2">
                  <p class="text-[#896163] dark:text-gray-400 text-xs font-bold uppercase tracking-widest">
                      {{ \Carbon\Carbon::parse($date)->isToday() 
                          ? 'Today' 
                          : (\Carbon\Carbon::parse($date)->isYesterday() 
                              ? 'Yesterday' 
                              : \Carbon\Carbon::parse($date)->format('d M Y')) }}
                  </p>
              </div>

              @foreach($items as $transaction)

                  @php
                      $isCredit = $transaction['type'] === 'credit';
                      $status = $transaction['status'];
                  @endphp

                  <div class="transaction-item flex items-center gap-4 bg-white dark:bg-background-dark px-4 min-h-[84px] py-3 justify-between border-b border-gray-50 dark:border-white/5" data-type="{{ $isCredit ? 'credit' : 'debit' }}"
                    data-status="{{ $status }}">

                      <div class="flex items-center gap-4">
                          <div class="
                              {{ $isCredit ? 'text-status-success bg-status-success/10' : 'text-primary bg-primary/10' }}
                              flex items-center justify-center rounded-full shrink-0 size-12">

                              <span class="material-symbols-outlined">
                                  {{ $isCredit ? 'south_west' : 'north_east' }}
                              </span>
                          </div>

                          <div>
                              <p class="text-[#181111] dark:text-white text-base font-semibold">
                                  {{ $transaction['title'] }}
                              </p>

                              @if(isset($transaction['transaction_id']) && $transaction['transaction_id'])
                                  <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                    Transaction ID: {{ $transaction['transaction_id'] }}
                                  </p>
                              @endif

                              @if(isset($transaction['operator']) && $transaction['operator'])
                                  <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                      {{ $transaction['operator'] }}
                                  </p>
                              @elseif(isset($transaction['bank_name']) && $transaction['bank_name'])
                                  <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                      {{ $transaction['bank_name'] }}
                                  </p>
                              @elseif(isset($transaction['gateway']) && $transaction['gateway'])
                                  <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                      {{ $transaction['gateway'] }}
                                  </p>
                              @endif

                              @if(isset($transaction['details']) && $transaction['details'])
                                  <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                      {!! $transaction['details'] !!}
                                  </p>
                              @elseif(isset($transaction['mobile']) && $transaction['mobile'])
                                  <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                      {{ $transaction['mobile'] }}
                                  </p>
                              @elseif(isset($transaction['t_type']) && $transaction['t_type'])
                                  <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                      {{ ucfirst($transaction['t_type']) }}
                                  </p>
                              @endif

                              @if(isset($transaction['r_type']) && $transaction['r_type'])
                                  <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                      {{ ucfirst($transaction['r_type']) }}
                                  </p>
                              @endif

                              <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                  {{ \Carbon\Carbon::parse($transaction['date'])->format('h:i A') }}
                              </p>
                          </div>
                      </div>

                      <div class="flex flex-col items-end gap-1">

                          <p class="
                              {{ $isCredit ? 'text-status-success' : 'text-[#181111] dark:text-white' }}
                              text-base font-bold
                              {{ $status == 2 ? 'line-through text-gray-400' : '' }}
                          ">
                              {{ $isCredit ? '+' : '-' }}
                              ৳{{ number_format($transaction['amount'], 2) }}
                          </p>

                          <span class="
                              text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider
                              {{ $status == 1 ? 'bg-status-success/10 text-status-success' :
                                ($status == 0 ? 'bg-status-pending/10 text-status-pending' :
                                'bg-status-failed/10 text-status-failed') }}
                          ">
                              {{ $status == 1 ? 'Success' : ($status == 0 ? 'Pending' : 'Failed') }}
                          </span>

                      </div>

                  </div>

              @endforeach

          @empty
              <div class="text-center py-10 text-gray-400">
                  No transactions found.
              </div>
          @endforelse
        </main>
    </div>
@endsection



@section('script')
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#EA2831",
                        "background-light": "#f8f6f6",
                        "background-dark": "#211111",
                        "status-success": "#10b981",
                        "status-pending": "#f59e0b",
                        "status-failed": "#ec131e"
                    },
                    fontFamily: {
                        display: "Manrope"
                    },
                    borderRadius: {
                        DEFAULT: "1rem",
                        lg: "2rem",
                        xl: "3rem",
                        full: "9999px"
                    }
                }
            }
        };
    </script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const filterBtns = document.querySelectorAll('.filter-btn');
      const transactions = document.querySelectorAll('.transaction-item');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.filter;

                filterBtns.forEach(b => {
                    b.classList.remove('bg-primary');
                    b.classList.add('bg-gray-100', 'dark:bg-white/5');

                    const p = b.querySelector('p');
                    p.classList.remove('text-white');
                    p.classList.add('text-[#181111]', 'dark:text-white');
                });

                btn.classList.add('bg-primary');
                btn.classList.remove('bg-gray-100', 'dark:bg-white/5');
                const p = btn.querySelector('p');
                p.classList.add('text-white');
                p.classList.remove('text-[#181111]', 'dark:text-white');

                transactions.forEach(tr => {
                    const type = tr.dataset.type;      
                    const status = tr.dataset.status;  

                    switch(filter) {
                        case 'all':
                            tr.style.display = 'flex';
                            break;
                        case 'sent':
                            tr.style.display = (type === 'debit') ? 'flex' : 'none';
                            break;
                        case 'received':
                            tr.style.display = (type === 'credit') ? 'flex' : 'none';
                            break;
                        case 'pending':
                            tr.style.display = (status == 0) ? 'flex' : 'none';
                            break;
                        case 'success':
                            tr.style.display = (status == 1) ? 'flex' : 'none';
                            break;
                        case 'failed':
                            tr.style.display = (status == 2) ? 'flex' : 'none';
                            break;
                    }
                });
            });
        });
    });
  </script>
@endsection
