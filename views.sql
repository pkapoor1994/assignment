drop view allgstcatg_view;
create view allgstcatg_view as
    select 'Product Master' as entname,gsttype from prod group by gsttype;

create view glmast_view as 
    select a.*,(CASE when b.schdes is null then '' ELSE b.schdes END) as schdes,
	(CASE when c.city is null then '' ELSE c.city END) as city,
	(CASE when c.statid is null then '' ELSE c.statid END) as statid,
	(CASE when d.statdes is null then '' ELSE d.statdes END) as statdes,
	(CASE when e.catgdes is null then '' ELSE e.catgdes END) as catgdes 
	from glmast a left join schmst b on a.sch=b.sch 
    left join city c on a.ctid=c.ctid 
    left join states d on c.statid=d.statid
    left join catgmst e on a.catgid=e.catgid;

create view prod_view as 
    select a.*,b.gln as gln1,c.gdes,d.gstdes,d.gper1,d.gper2,d.gper3,gstype,e.gln as gln2,f.unit from prod a 
    left join glmast b on a.glc1=b.glc 
    left join grpmst c on a.grp=c.grp 
    left join gstcatg d on a.gsttype=d.gsttype
    left join glmast e on a.glc2=e.glc
    left join unitmst f on a.unid=f.unid;

drop view stk1_view;
create view stk1_view as 
	select trackno,prod.prate,prod.srate,tc,ser,docno,docdt,prod.grp,sale.pcode,prod.pname,
	qty as yob,00000000.00 as qty1,00000000.00 as qty2, 
	00000000.00 as qty3,00000000.00 as qty4,00000000.00 as qty5,00000000.00 as mob,00000000.00 as mobamt
	from sale,prod where tc='P11' and prod.pcode=sale.pcode and docdt<fn_mdate1() 
	UNION all
	select trackno,prod.prate,prod.srate,tc,ser,docno,docdt,prod.grp,sale.pcode,prod.pname,
	qty*-1 as yob,00000000.00 as qty1,00000000.00 as qty2, 
	00000000.00 as qty3,00000000.00 as qty4,00000000.00 as qty5,00000000.00 as mob,00000000.00 as mobamt
	from sale,prod where tc='S11' and prod.pcode=sale.pcode and docdt<fn_mdate1() 
	UNION all
	select trackno,prod.prate,prod.srate,tc,ser,docno,docdt,prod.grp,sale.pcode,prod.pname,
	00000000.00  as yob,qty as qty1,00000000.00 as qty2, 
	00000000.00 as qty3,00000000.00 as qty4,00000000.00 as qty5,00000000.00 as mob,00000000.00 as mobamt from sale,
	prod where tc='P11' and prod.pcode=sale.pcode and docdt>=fn_mdate1()  and docdt<=fn_mdate2()
	UNION all
	select trackno,prod.prate,prod.srate,tc,ser,docno,docdt,prod.grp,sale.pcode,prod.pname,
	00000000.00  as yob,00000000.00 as qty1,qty as qty2, 
	00000000.00 as qty3,00000000.00 as qty4,00000000.00 as qty5,00000000.00 as mob,00000000.00 as mobamt 
	from sale,prod where tc='S11' and prod.pcode=sale.pcode and docdt>=fn_mdate1()  and docdt<=fn_mdate2()


drop view stk_view ;
create view stk_view as 
	select grp,pcode,pname,sum(yob) as yob,sum(qty1) as qty1,sum(qty2) as qty2,sum(qty3) as qty3,sum(qty4) as qty4,sum(qty5) as qty5
	from stk1_view group by grp,pcode,pname;