<style>

.investment-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    padding:20px;
    background:#fff;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.investment-header h1{
    margin:0;
    font-size:28px;
    color:#111827;
}

.investment-header small{
    color:#6b7280;
    font-size:14px;
}

.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    margin-bottom:35px;
}

.summary-card{
    background:white;
    border-radius:12px;
    padding:20px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    display:flex;
    flex-direction:column;
    gap:8px;
    font-size:14px;
    color:#6b7280;
}

.summary-card strong{
    font-size:22px;
    color:#111827;
}

.module-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:20px;
}

.module-card{
    text-decoration:none;
    background:white;
    border-radius:14px;
    padding:25px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    transition:.25s;
    color:#111827;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:10px;
    min-height:140px;
}

.module-card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

.module-card .icon{
    font-size:40px;
}

.module-card .title{
    font-size:16px;
    font-weight:600;
}

.module-card .action{
    font-size:13px;
    color:#2563eb;
}

.info-section{
    margin-top:40px;
    background:white;
    border-radius:12px;
    padding:25px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.info-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.info-item{
    padding:12px;
    border-bottom:1px solid #e5e7eb;
}

.info-label{
    font-size:13px;
    color:#6b7280;
    margin-bottom:5px;
}

.info-value{
    font-weight:600;
    color:#111827;
}

.metric-good{
    color:#16a34a;
}

.metric-warning{
    color:#ca8a04;
}

.metric-danger{
    color:#dc2626;
}

@media(max-width:768px){

    .investment-header{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

}

.table-dashboard td:nth-child(2),
.table-dashboard td:nth-child(3),
.table-dashboard td:nth-child(4){
    text-align:center;
}

.table-dashboard th{
    text-align:center;
}

.table-dashboard td:first-child{
    text-align:left;
}

.table-dashboard tbody tr{
    transition:all .2s ease;
}

.table-dashboard tbody tr:hover{
    background:#eff6ff !important;
    cursor:pointer;
}

.table-dashboard tbody tr:hover td:first-child{
    color:#2563eb;
    font-weight:700;
}

.table-dashboard{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    margin:0 auto;
    text-align:center;
}

.table-dashboard th{
    text-align:center;
    vertical-align:middle;
}

.table-dashboard td{
    text-align:center;
    vertical-align:middle;
}

.table-dashboard td:first-child{
    text-align:left;
}

.table-dashboard th:first-child{
    text-align:left;
}

</style>