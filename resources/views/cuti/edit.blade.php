 <form action="{{ url('/cuti/update/' . $cuti->kode_cuti) }}" method="POST" id="form-addCuti">
     @csrf
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M7 12h3v4h-3z" />
                         <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" />
                         <path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                         <path d="M14 16h2" />
                         <path d="M14 12h4" />
                     </svg> </span>
                 <input type="text" value="{{ $cuti->kode_cuti }}" id="kode_cuti" class="form-control"
                     name="kode_cuti" placeholder="Kode Dept" disabled>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                         <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                         <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                     </svg> </span>
                 <input type="text" value="{{ $cuti->nama_cuti }}" id="nama_cuti" class="form-control"
                     name="nama_cuti" placeholder="Nama Cuti">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                         <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                         <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                     </svg> </span>
                 <input type="text" value="{{ $cuti->jml_hari }}" id="jml_hari" class="form-control"
                     name="jml_hari" placeholder="Jumlah Hari">
             </div>
         </div>
     </div>
     <div class="row mt-2">
         <div class="col-12">
             <div class="form-group">
                 <button class="btn btn-primary w-100">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M10 14l11 -11" />
                         <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                     </svg>
                     Update
                 </button>
             </div>
         </div>
     </div>
 </form>
