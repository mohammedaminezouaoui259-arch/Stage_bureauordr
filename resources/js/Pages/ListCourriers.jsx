import { useEffect, useState } from "react";
import { router } from "@inertiajs/react";

export default function ListCourriers() {

const [courriers, setCourriers] = useState([]);
const [search, setSearch] = useState("");

useEffect(() => {

fetch("/api/courriers")
.then(res => res.json())
.then(data => {
setCourriers(data);
});

}, []);

const filtered = courriers.filter(c => {

const numero = c.numero ? c.numero.toLowerCase() : "";
const objet = c.objet ? c.objet.toLowerCase() : "";
const s = search.toLowerCase();

return numero.includes(s) || objet.includes(s);

});

const getStatut = (c) => {

if(c.courrier_arrive_id){
return {text:"Réponse envoyée",color:"bg-green-100 text-green-700"};
}

if(c.type === "depart"){
return {text:"Envoyé",color:"bg-blue-100 text-blue-700"};
}

return {text:"Reçu",color:"bg-yellow-100 text-yellow-700"};

}

return (

<div className="p-10 bg-gray-100 min-h-screen">

<div className="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-8">

<div className="flex justify-between items-center mb-6">

<h1 className="text-3xl font-bold text-gray-800">
Liste des Courriers
</h1>

<button
onClick={()=>router.visit("/")}
className="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700"
>
Accueil
</button>

</div>

<input
type="text"
placeholder="Rechercher par numéro ou objet..."
value={search}
onChange={(e)=>setSearch(e.target.value)}
className="border border-gray-300 rounded-lg p-3 w-full mb-6 focus:outline-none focus:ring-2 focus:ring-blue-400"
/>

<table className="w-full border border-gray-200 rounded-lg overflow-hidden">

<thead className="bg-gray-200 text-gray-700">

<tr>
<th className="p-3 border">Numero</th>
<th className="p-3 border">Objet</th>
<th className="p-3 border">Type</th>
<th className="p-3 border">Date</th>
<th className="p-3 border">Service</th>
<th className="p-3 border">Statut</th>
<th className="p-3 border">PDF</th>
<th className="p-3 border">Télécharger</th>
</tr>

</thead>

<tbody>

{filtered.length === 0 ? (

<tr>
<td colSpan="8" className="text-center p-6 text-gray-500">
Aucun courrier trouvé
</td>
</tr>

) : (

filtered.map(c => {

const service = c.affectations?.[0]?.service?.nom_service || "-";

const statut = getStatut(c);

const date = c.date_arrivee || c.date_depart || "-";

return (

<tr key={c.id} className="hover:bg-gray-100">

<td className="border p-3 font-semibold">
{c.numero}
</td>

<td className="border p-3">
{c.objet}
</td>

<td className="border p-3 text-center">

<span className={`px-3 py-1 rounded-full text-sm ${
c.type === "depart"
? "bg-purple-100 text-purple-700"
: "bg-blue-100 text-blue-700"
}`}>
{c.type === "depart" ? "Départ" : "Arrivée"}
</span>

</td>

<td className="border p-3 text-center">
{date}
</td>

<td className="border p-3">
{service}
</td>

<td className="border p-3 text-center">

<span className={`px-3 py-1 rounded-full text-sm ${statut.color}`}>
{statut.text}
</span>

</td>

<td className="border p-3 text-center">

{c.fichier ? (

<a
href={`/storage/${c.fichier}`}
target="_blank"
className="text-blue-600 font-semibold hover:underline"
>
Voir
</a>

) : "-"}

</td>

<td className="border p-3 text-center">

<a
href={`/api/courriers/${c.id}/pdf`}
className="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
>
Télécharger
</a>

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