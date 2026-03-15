import { useEffect, useState } from "react";
import { router } from "@inertiajs/react";

export default function ListCourriers() {

const [courriers, setCourriers] = useState([]);
const [search, setSearch] = useState("");
const [annee, setAnnee] = useState("");

useEffect(() => {
loadCourriers();
}, []);

const loadCourriers = () => {

fetch("/api/courriers")
.then(res => res.json())
.then(data => {
setCourriers(Array.isArray(data) ? data : []);
})
.catch(() => setCourriers([]));

};

const filtered = courriers.filter(c => {

const numero = c.numero ? c.numero.toLowerCase() : "";
const objet = c.objet ? c.objet.toLowerCase() : "";
const s = search.toLowerCase();

return numero.includes(s) || objet.includes(s);

});

const deleteCourrier = (id) => {

if(!confirm("Supprimer ce courrier ?")) return;

fetch(`/api/courriers/${id}`,{
method:"DELETE"
})
.then(()=> loadCourriers());

};

const voirCourrier = (c) => {

if(c.fichier){
window.open(`/storage/${c.fichier}`,"_blank");
}

fetch(`/api/courriers/${c.id}/valider`,{
method:"PUT"
})
.then(()=> loadCourriers());

};

const telecharger = (c) => {

window.open(`/api/courriers/download/${c.id}`,"_blank");

};

const genererPdf = () => {

if(!annee){
alert("Choisir une année");
return;
}

window.open(`/api/courriers/generer-pdf/${annee}`,"_blank");

};

const annees = [...new Set(courriers.map(c => c.annee))];

return (

<div className="p-10 bg-gray-100 min-h-screen">

<div className="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-8">

<div className="flex justify-between items-center mb-6">

<h1 className="text-3xl font-bold text-gray-800">
Liste Courrier Arrivée
</h1>

<button
onClick={()=>router.visit("/")}
className="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700"
>
Accueil
</button>

</div>

{/* zone recherche + année */}

<div className="flex items-center gap-4 mb-6">

<input
type="text"
placeholder="Rechercher..."
value={search}
onChange={(e)=>setSearch(e.target.value)}
className="border border-gray-300 rounded-lg p-2 w-64"
/>

<select
value={annee}
onChange={(e)=>setAnnee(e.target.value)}
className="border border-gray-300 rounded-lg p-2"
>

<option value="">Année</option>

{annees.map(a=>(
<option key={a} value={a}>{a}</option>
))}

</select>

<button
onClick={genererPdf}
className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
>
Générer PDF
</button>

</div>

<table className="w-full border border-gray-200 rounded-lg overflow-hidden">

<thead className="bg-gray-200 text-gray-700">

<tr>
<th className="p-3 border">Numero</th>
<th className="p-3 border">Année</th>
<th className="p-3 border">Objet</th>
<th className="p-3 border">Date arrivée</th>
<th className="p-3 border">Service</th>
<th className="p-3 border">Statut</th>
<th className="p-3 border">Voir</th>
<th className="p-3 border">Télécharger</th>
<th className="p-3 border">Modifier</th>
<th className="p-3 border">Supprimer</th>
</tr>

</thead>

<tbody>

{filtered.length === 0 ? (

<tr>
<td colSpan="10" className="text-center p-6 text-gray-500">
Aucun courrier trouvé
</td>
</tr>

) : (

filtered.map(c => {

const service = c.affectations?.[0]?.service?.nom_service || "-";

return (

<tr key={c.id} className="hover:bg-gray-100">

<td className="border p-3 font-semibold">
{c.numero}
</td>

<td className="border p-3 text-center">
{c.annee}
</td>

<td className="border p-3">
{c.objet}
</td>

<td className="border p-3 text-center">
{c.date_arrivee}
</td>

<td className="border p-3">
{service}
</td>

<td className="border p-3 text-center">

<span className={`px-3 py-1 rounded-full text-sm ${
c.status_id == 1
? "bg-yellow-100 text-yellow-700"
: "bg-green-100 text-green-700"
}`}>

{c.status_id == 1 ? "Draft" : "Validé"}

</span>

</td>

<td className="border p-3 text-center">

<button
onClick={()=>voirCourrier(c)}
className="text-blue-600 hover:underline"
>
Voir
</button>

</td>

<td className="border p-3 text-center">

<button
onClick={()=>telecharger(c)}
className="text-green-600 hover:underline"
>
Télécharger
</button>

</td>

<td className="border p-3 text-center">

<button
onClick={()=>router.visit(`/courriers/create?id=${c.id}`)}
className="text-orange-600 hover:underline"
>
Modifier
</button>

</td>

<td className="border p-3 text-center">

<button
onClick={()=>deleteCourrier(c.id)}
className="text-red-600 hover:underline"
>
Supprimer
</button>

</td>

</tr>

)

})

)}

</tbody>

</table>

</div>

</div>

);

}