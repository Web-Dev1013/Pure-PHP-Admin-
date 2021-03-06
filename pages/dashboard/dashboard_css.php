<style>
body{
    background: #eee;
    font-family: math !important;
}
.content{
    background: white;
    box-shadow: 0 4px 20px #1515159d;
}
:focus{
    box-shadow: none !important;
    outline: none !important;
}
.budget{
    background: yellow;
}
.alert{
    display: block !important;
    position: fixed;
    bottom: 0;
    padding: 3%;
    text-align: left;
    right: -30%;
    z-index: 10;
    min-height: 10vh;
    min-width: 20%;
    color: white;
    font-size: 18px !important;
    transition: 0.5s ease-in-out;
}

.alert-success{
    border-top: 6px solid rgb(1, 78, 1);
    background: rgb(1, 110, 1) !important;
}
.alert-danger{
    border-top: 6px solid rgb(107, 1, 1);
    background: rgb(151, 1, 1) !important;
}

.alert-active{
    right: 0 !important;
    transition: 0.5s;
}

.text-gold {
    color: #d0aa3c;
}
.border-gold{
    border-color: #d0aa3c !important;
}
.table-hover tbody tr:hover{
    background-color: #d0aa3c !important;
    cursor: pointer;
}
.page-table{
    overflow-x: auto;
}
.btn-warning {
    background-color: #d0aa3c !important;
    color: white !important;
    border-color: #d0aa3c !important;
}
.table td, .table th{
    padding: 6px  !important;
    font-size: 14px !important;
    font-weight: bold;
    vertical-align: middle !important;
    color: #333;
}
.add_category:hover{
    cursor: pointer;
}
input[type=text]{
    border-color: #d0aa3c;
}
</style>