import { useEffect, useState } from "react"
import Select from "react-select"

export default function CreateCourrier(){

const [numero,setNumero] = useState("")
const [objet,setObjet] = useState("")
const [type,setType] = useState("entrant")
const [date,setDate] = useState("")
const [description,setDescription] = useState("")
const [expediteur,setExpediteur] = useState("")
const [destinataire,setDestinataire] = useState("")
const [services,setServices] = useState([])
const [serviceId,setServiceId] = useState("")
const [fichier,setFichier] = useState(null)
const [loading,setLoading] = useState(false)

useEffect(()=>{

fetch("/api/courriers/next-number")
.then(res=>res.json())
.then(data=>{
setNumero(data.numero)
})

fetch("/api/services")
.then(res=>res.json())
.then(data=>{
setServices(data)
})

},[])

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

if(!objet || !date || !serviceId){
alert("Veuillez remplir les champs obligatoires")
return
}

setLoading(true)

const formData = new FormData()

formData.append("numero",numero)
formData.append("objet",objet)
formData.append("type",type)
formData.append("date_courrier",date)
formData.append("description",description)
formData.append("expediteur",expediteur)
formData.append("destinataire",destinataire)
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

setObjet("")
setDescription("")
setExpediteur("")
setDestinataire("")
setServiceId("")
setFichier(null)

setLoading(false)

fetch("/api/courriers/next-number")
.then(res=>res.json())
.then(data=>{
setNumero(data.numero)
})

})
.catch(()=>{
alert("Erreur lors de l'ajout")
setLoading(false)
})

}

return(

<div className="min-h-screen bg-gray-100 flex justify-center items-center p-6">

<div className="bg-white shadow-xl rounded-xl w-full max-w-3xl p-8">

<h1 className="text-2xl font-bold text-gray-700 mb-6 border-b pb-3">
Ajouter un Courrier
</h1>

<form onSubmit={submitForm} className="space-y-4">

<div>
<label className="block text-sm font-medium text-gray-600">Numero</label>
<input
type="text"
value={numero}
readOnly
className="w-full border rounded-lg p-2 bg-gray-100"
/>
</div>

<div>
<label className="block text-sm font-medium text-gray-600">Objet *</label>
<input
type="text"
value={objet}
onChange={(e)=>setObjet(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div className="grid grid-cols-2 gap-4">

<div>
<label className="block text-sm font-medium text-gray-600">Type</label>
<select
value={type}
onChange={(e)=>setType(e.target.value)}
className="w-full border rounded-lg p-2"
>
<option value="entrant">Entrant</option>
<option value="sortant">Sortant</option>
</select>
</div>

<div>
<label className="block text-sm font-medium text-gray-600">Date *</label>
<input
type="date"
value={date}
onChange={(e)=>setDate(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

</div>

<div>
<label className="block text-sm font-medium text-gray-600">Description</label>
<textarea
value={description}
onChange={(e)=>setDescription(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div className="grid grid-cols-2 gap-4">

<div>
<label className="block text-sm font-medium text-gray-600">Expediteur</label>
<input
type="text"
value={expediteur}
onChange={(e)=>setExpediteur(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

<div>
<label className="block text-sm font-medium text-gray-600">Destinataire</label>
<input
type="text"
value={destinataire}
onChange={(e)=>setDestinataire(e.target.value)}
className="w-full border rounded-lg p-2"
/>
</div>

</div>

<div>
<label className="block text-sm font-medium text-gray-600">Service *</label>

<Select
options={serviceOptions}
onChange={handleServiceChange}
placeholder="Rechercher ou ajouter service..."
isClearable
isSearchable
formatCreateLabel={(inputValue)=>`Ajouter "${inputValue}"`}
/>

</div>

<div>
<label className="block text-sm font-medium text-gray-600">
Scan Courrier (PDF)
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
className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow w-full"
>
{loading ? "Enregistrement..." : "Enregistrer"}
</button>

</form>

</div>

</div>

)

}