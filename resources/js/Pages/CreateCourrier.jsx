import { useEffect, useState } from "react"
import CreatableSelect from "react-select/creatable"
import { router } from "@inertiajs/react"

export default function CreateCourrier(){

const [numero,setNumero] = useState("")
const [annee,setAnnee] = useState(new Date().getFullYear())
const [objet,setObjet] = useState("")
const [type,setType] = useState("")
const [date,setDate] = useState("")
const [description,setDescription] = useState("")
const [expediteur,setExpediteur] = useState("")
const [destinataire,setDestinataire] = useState("")
const [nombrePieces,setNombrePieces] = useState("")
const [observations,setObservations] = useState("")
const [natureId,setNatureId] = useState("")
const [natures,setNatures] = useState([])
const [services,setServices] = useState([])
const [serviceId,setServiceId] = useState("")
const [fichier,setFichier] = useState(null)
const [loading,setLoading] = useState(false)

useEffect(()=>{

fetch("/api/courriers/next-number?annee="+annee)
.then(res=>res.json())
.then(data=>{
setNumero(data.numero)
})

fetch("/api/services")
.then(res=>res.json())
.then(data=>{
setServices(data)
})

fetch("/api/natures")
.then(res=>res.json())
.then(data=>{
setNatures(data)
})

},[annee])

const serviceOptions = services.map(s=>({
value:s.id,
label:s.nom_service
}))

const handleServiceChange = (selected)=>{

if(!selected){
setServiceId("")
return
}

if(selected.__isNew__){

fetch("/api/services",{
method:"POST",
headers:{
"Content-Type":"application/json"
},
body:JSON.stringify({
nom_service:selected.label
})
})
.then(res=>res.json())
.then(data=>{
setServices([...services,data.service])
setServiceId(data.service.id)
})

}else{

setServiceId(selected.value)

}

}

const submitForm = (e)=>{

e.preventDefault()

if(!objet || !date || !serviceId || !natureId || !type){
alert("Veuillez remplir les champs obligatoires")
return
}

setLoading(true)

const formData = new FormData()

formData.append("numero",numero)
formData.append("annee",annee)
formData.append("type",type)
formData.append("objet",objet)
formData.append("date_courrier",date)
formData.append("description",description)
formData.append("expediteur",expediteur)
formData.append("destinataire",destinataire)
formData.append("nombre_pieces",nombrePieces)
formData.append("observations",observations)
formData.append("nature_id",natureId)
formData.append("service_id",serviceId)

if(fichier){
formData.append("fichier",fichier)
}

fetch("/api/courriers",{
method:"POST",
body:formData
})
.then(res=>res.json())
.then(()=>{

alert("Courrier ajouté avec succès")

router.visit("/courriers")

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
Nouveau Courrier Arrivée
</h1>

<div className="flex gap-3">

<button
type="button"
onClick={()=>router.visit("/")}
className="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
>
Accueil
</button>

<button
type="button"
onClick={()=>router.visit("/courriers")}
className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
>
Liste Courriers
</button>

</div>

</div>

<form onSubmit={submitForm} className="space-y-5">

<div className="grid grid-cols-2 gap-4">

<div>
<label className="text-sm font-medium">Année</label>
<input
type="number"
value={annee}
onChange={(e)=>setAnnee(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div>
<label className="text-sm font-medium">Numéro</label>
<input
type="text"
value={numero}
onChange={(e)=>setNumero(e.target.value)}
className="w-full border rounded-lg p-2 bg-gray-100"
/>
</div>

</div>

<div>
<label className="text-sm font-medium">Date d'arrivée *</label>
<input
type="date"
value={date}
max={new Date().toISOString().split("T")[0]}
onChange={(e)=>setDate(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div>
<label className="text-sm font-medium">Objet *</label>
<input
type="text"
value={objet}
onChange={(e)=>setObjet(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div>
<label className="text-sm font-medium">Type de courrier *</label>
<select
value={type}
onChange={(e)=>setType(e.target.value)}
className="w-full border rounded-lg p-2"
>

<option value="">Choisir type</option>
<option value="Facture">Facture</option>
<option value="Note">Note</option>
<option value="Réclamation">Réclamation</option>
<option value="Officiel">Officiel</option>

</select>
</div>

<div>
<label className="text-sm font-medium">Nature *</label>

<select
value={natureId}
onChange={(e)=>setNatureId(e.target.value)}
className="w-full border rounded-lg p-2"
>

<option value="">Choisir nature</option>

{natures.map(n=>(
<option key={n.id} value={n.id}>
{n.nom}
</option>
))}

</select>

</div>

<div className="grid grid-cols-2 gap-4">

<div>
<label className="text-sm font-medium">Nombre de pièces</label>
<input
type="number"
value={nombrePieces}
onChange={(e)=>setNombrePieces(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div>
<label className="text-sm font-medium">Expéditeur</label>
<input
type="text"
value={expediteur}
onChange={(e)=>setExpediteur(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

</div>

<div>
<label className="text-sm font-medium">Destinataire</label>
<input
type="text"
value={destinataire}
onChange={(e)=>setDestinataire(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div>
<label className="text-sm font-medium">Description</label>
<textarea
value={description}
onChange={(e)=>setDescription(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div>
<label className="text-sm font-medium">Observations</label>
<textarea
value={observations}
onChange={(e)=>setObservations(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div>

<label className="text-sm font-medium">
Service destinataire *
</label>

<CreatableSelect
options={serviceOptions}
onChange={handleServiceChange}
placeholder="Rechercher ou ajouter service..."
isClearable
isSearchable
/>

</div>

<div>
<label className="text-sm font-medium">
Scan courrier (PDF)
</label>
<input
type="file"
accept="application/pdf"
onChange={(e)=>setFichier(e.target.files[0])}
className="w-full border rounded-lg p-2"
/>
</div>

<button
type="submit"
disabled={loading}
className="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg w-full text-lg"
>

{loading ? "Enregistrement..." : "Enregistrer le courrier"}

</button>

</form>

</div>

</div>

)

}