import { useEffect, useState } from "react"
import { router } from "@inertiajs/react"

export default function CreateCourrierDepart(){

const [numero,setNumero] = useState("")
const [annee,setAnnee] = useState(new Date().getFullYear())
const [objet,setObjet] = useState("")
const [type,setType] = useState("")
const [dateDepart,setDateDepart] = useState("")
const [destinataire,setDestinataire] = useState("")
const [modeEnvoi,setModeEnvoi] = useState("")
const [description,setDescription] = useState("")
const [nombrePieces,setNombrePieces] = useState("")
const [observations,setObservations] = useState("")
const [natureId,setNatureId] = useState("")
const [natures,setNatures] = useState([])
const [courrierArriveId,setCourrierArriveId] = useState("")
const [courriers,setCourriers] = useState([])
const [fichier,setFichier] = useState(null)
const [loading,setLoading] = useState(false)

const today = new Date().toISOString().split("T")[0]

useEffect(()=>{

fetch("/api/courrier-departs/next-number?annee="+annee)
.then(res=>res.json())
.then(data=>{
setNumero(data.numero)
})

fetch("/api/natures")
.then(res=>res.json())
.then(data=>{
setNatures(data)
})

fetch("/api/courriers")
.then(res=>res.json())
.then(data=>{
setCourriers(data)
})

},[annee])

const submitForm = (e)=>{

e.preventDefault()

if(!objet || !dateDepart || !destinataire || !modeEnvoi || !natureId){
alert("Veuillez remplir les champs obligatoires")
return
}

setLoading(true)

const formData = new FormData()

formData.append("numero",numero)
formData.append("annee",annee)
formData.append("type",type)
formData.append("objet",objet)
formData.append("date_depart",dateDepart)
formData.append("destinataire_externe",destinataire)
formData.append("mode_envoi",modeEnvoi)
formData.append("description",description)
formData.append("nombre_pieces",nombrePieces)
formData.append("observations",observations)
formData.append("nature_id",natureId)
formData.append("courrier_arrive_id",courrierArriveId)

if(fichier){
formData.append("fichier",fichier)
}

fetch("/api/courrier-departs",{
method:"POST",
body:formData
})
.then(res=>res.json())
.then(()=>{

alert("Courrier départ ajouté avec succès")

router.visit("/courrier-departs")

})
.catch(()=>{

alert("Erreur lors de l'ajout")
setLoading(false)

})

}

return(

<div className="min-h-screen bg-gray-100 p-8">

<div className="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-8">

<div className="flex justify-between items-center mb-6 border-b pb-4">

<h1 className="text-2xl font-bold text-gray-700">
Nouveau Courrier Départ
</h1>

<button
type="button"
onClick={()=>router.visit("/")}
className="bg-gray-500 text-white px-4 py-2 rounded"
>
Accueil
</button>

</div>

<form onSubmit={submitForm} className="space-y-5">

<div className="grid grid-cols-2 gap-4">

<div>
<label>Année</label>
<input
type="number"
value={annee}
onChange={(e)=>setAnnee(e.target.value)}
className="w-full border p-2 rounded"
/>
</div>

<div>
<label>Numéro</label>
<input
type="text"
value={numero}
onChange={(e)=>setNumero(e.target.value)}
className="w-full border p-2 rounded"
/>
</div>

</div>

<div>
<label>Date de départ *</label>
<input
type="date"
value={dateDepart}
max={today}
onChange={(e)=>setDateDepart(e.target.value)}
className="w-full border p-2 rounded"
/>
</div>

<div>
<label>Objet *</label>
<input
type="text"
value={objet}
onChange={(e)=>setObjet(e.target.value)}
className="w-full border p-2 rounded"
/>
</div>

<div>
<label>Type de courrier</label>
<select
value={type}
onChange={(e)=>setType(e.target.value)}
className="w-full border p-2 rounded"
>

<option value="">Choisir type</option>
<option value="Facture">Facture</option>
<option value="Note">Note</option>
<option value="Réclamation">Réclamation</option>
<option value="Officiel">Officiel</option>

</select>
</div>

<div>
<label>Destinataire externe *</label>
<input
type="text"
value={destinataire}
onChange={(e)=>setDestinataire(e.target.value)}
className="w-full border p-2 rounded"
/>
</div>

<div>
<label>Mode d'envoi *</label>
<select
value={modeEnvoi}
onChange={(e)=>setModeEnvoi(e.target.value)}
className="w-full border p-2 rounded"
>

<option value="">Choisir</option>
<option value="Poste">Poste</option>
<option value="Email">Email</option>
<option value="Remise">Remise en main propre</option>

</select>
</div>

<div>
<label>Nature</label>

<select
value={natureId}
onChange={(e)=>setNatureId(e.target.value)}
className="w-full border p-2 rounded"
>

<option value="">Choisir nature</option>

{natures.map(n=>(
<option key={n.id} value={n.id}>
{n.nom}
</option>
))}

</select>

</div>

<div>
<label>Réponse à (courrier arrivé)</label>

<select
value={courrierArriveId}
onChange={(e)=>setCourrierArriveId(e.target.value)}
className="w-full border p-2 rounded"
>

<option value="">Pas de réponse</option>

{courriers.map(c=>(
<option key={c.id} value={c.id}>
{c.numero} - {c.objet}
</option>
))}

</select>

</div>

<div>
<label>Nombre de pièces</label>
<input
type="number"
value={nombrePieces}
onChange={(e)=>setNombrePieces(e.target.value)}
className="w-full border p-2 rounded"
/>
</div>

<div>
<label>Description</label>
<textarea
value={description}
onChange={(e)=>setDescription(e.target.value)}
className="w-full border p-2 rounded"
/>
</div>

<div>
<label>Observations</label>
<textarea
value={observations}
onChange={(e)=>setObservations(e.target.value)}
className="w-full border p-2 rounded"
/>
</div>

<div>
<label>Scan courrier (PDF)</label>
<input
type="file"
accept="application/pdf"
onChange={(e)=>setFichier(e.target.files[0])}
className="w-full border p-2 rounded"
/>
</div>

<button
type="submit"
disabled={loading}
className="bg-green-600 text-white px-6 py-3 rounded w-full"
>

{loading ? "Enregistrement..." : "Enregistrer"}

</button>

</form>

</div>

</div>

)

}