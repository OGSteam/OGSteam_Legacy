using System;
using System.Collections.Generic;
using System.Windows.Forms;
using System.Text.RegularExpressions;
using System.Collections.ObjectModel;
using System.IO;
using System.Diagnostics;
using System.Drawing;
using System.Runtime.InteropServices;
using System.Text;

namespace Ogame
{
#if !UNIVERS_50
    static class Valeurs
    {
        public const int maxPlanete =  15 ;
        public const int maxSysteme = 499 ;
        public const int maxGalaxie =   9 ;
    }
#else
    static class Valeurs
    {
        public const int maxPlanete =  15 ;
        public const int maxSysteme = 100 ;
        public const int maxGalaxie =  50 ;
    }
#endif
}

namespace Ogame
{
    static public class log
    {
        static public void Debug( string s )
        {
#if TRACE
            DefaultTraceListener dtl = new DefaultTraceListener() ;
            dtl.WriteLine( s ) ;
#endif
        }
    }

    [Serializable]
    public class Ressources
    {
        public static implicit operator String(Ressources r)
        {
            String s = "" ;
            s += r.Metal + "M " ;
            s += r.Cristal + "C " ;
            s += r.Deuterium + "D" ;
            return s ;
        }

        public static implicit operator RessourcesLong(Ressources r)
        {
            return new RessourcesLong(r) ;
        }

        public static Ressources operator+ ( Ressources r1, Ressources r2 ) 
        {
            Ressources r = new Ressources(r1) ;
            r.Metal     += r2.Metal     ;
            r.Cristal   += r2.Cristal   ;
            r.Deuterium += r2.Deuterium ;
            r.Energie   += r2.Energie   ;
            return r ;
        }

        public static Ressources operator- ( Ressources r1, Ressources r2 ) 
        {
            Ressources r = new Ressources(r1) ;
            r.Metal     -= r2.Metal     ;
            r.Cristal   -= r2.Cristal   ;
            r.Deuterium -= r2.Deuterium ;
            r.Energie   -= r2.Energie   ;
            return r ;
        }

        public static Ressources operator* ( Ressources r1 , uint f )
        {
            Ressources r = new Ressources(r1) ;
            r.Metal     *= f ;
            r.Cristal   *= f ;
            r.Deuterium *= f ;
            r.Energie   *= f ;
            return r ;
        }

        public static Ressources operator/ ( Ressources r1 , uint f )
        {
            Ressources r = new Ressources(r1) ;
            r.Metal     /= f ;
            r.Cristal   /= f ;
            r.Deuterium /= f ;
            r.Energie   /= f ;
            return r ;
        }

        public static Ressources operator/ ( Ressources r1 , double f )
        {
            Ressources r = new Ressources(r1) ;
            r.Metal     = (uint)((double)r.Metal    /f) ;
            r.Cristal   = (uint)((double)r.Cristal  /f) ;
            r.Deuterium = (uint)((double)r.Deuterium/f) ;
            r.Energie   = (uint)((double)r.Energie  /f) ;
            return r ;
        }

        public static Ressources Minimum
        {
            get {
                Ressources r = new Ressources() ;
                r.Cristal   = UInt32.MinValue ;
                r.Metal     = UInt32.MinValue ;
                r.Deuterium = UInt32.MinValue ;
                return r ;
            }
        }
        public static Ressources Maximum
        {
            get {
                Ressources r = new Ressources() ;
                r.Cristal   = UInt32.MaxValue ;
                r.Metal     = UInt32.MaxValue ;
                r.Deuterium = UInt32.MaxValue ;
                return r ;
            }
        }

        public Ressources()
        {
            _Metal = 0;
            _Cristal = 0;
            _Deuterium = 0;
            _Energie = 0;
        }
        public Ressources( Ressources r )
        {
            this._Cristal = r._Cristal ;
            this._Deuterium = r._Deuterium ;
            this._Energie = r._Energie ;
            this._Metal = r._Metal ;
        }

        public Ressources( UInt32 Metal, UInt32 Cristal )
        {
            _Metal = Metal;
            _Cristal = Cristal;
            _Deuterium = 0;
            _Energie = 0;
        }

        public Ressources( UInt32 Metal, UInt32 Cristal, UInt32 Deuterium )
        {
            _Metal = Metal;
            _Cristal = Cristal;
            _Deuterium = Deuterium;
            _Energie = 0;
        }

        public void copie( Ressources r )
        {
            this.Metal = r.Metal ;
            this.Cristal = r.Cristal ;
            this.Deuterium = r.Deuterium ;
            this.Energie = r.Energie ;
        }

        public enum resType
        {
            Metal     ,
            Cristal   ,
            Deuterium
        }
        public UInt32 this[ resType typeDeRessource ]
        {
            get {
                switch( typeDeRessource )
                {
                    case resType.Metal :
                        return Metal ;
                    case resType.Cristal :
                        return Cristal ;
                    case resType.Deuterium :
                        return Deuterium ;
                    default :
                        throw new Exception("Ce type de ressource n'existe pas !") ;
                }
            }
            set {
                switch( typeDeRessource )
                {
                    case resType.Metal :
                        Metal = value ;
                        break ;
                    case resType.Cristal :
                        Cristal = value ;
                        break ;
                    case resType.Deuterium :
                        Deuterium = value ;
                        break ;
                    default :
                        throw new Exception("Ce type de ressource n'existe pas !") ;
                }
            }
        }
        private resType[] triDesRessource()
        {
            resType[] r = new resType[3] ;
            if ( Metal <= Cristal && Cristal <= Deuterium )
            {
                r[0] = resType.Metal ;
                r[1] = resType.Cristal ;
                r[2] = resType.Deuterium ;
            }
            else if ( Metal <= Deuterium && Deuterium <= Cristal )
            {
                r[0] = resType.Metal ;
                r[1] = resType.Deuterium ;
                r[2] = resType.Cristal ;
            }
            else if ( Cristal <= Metal && Metal <= Deuterium )
            {
                r[0] = resType.Cristal ;
                r[1] = resType.Metal ;
                r[2] = resType.Deuterium ;
            }
            else if ( Cristal <= Deuterium && Deuterium <= Metal )
            {
                r[0] = resType.Cristal ;
                r[1] = resType.Deuterium ;
                r[2] = resType.Metal ;
            }
            else if ( Deuterium <= Cristal && Cristal <= Metal )
            {
                r[0] = resType.Deuterium ;
                r[1] = resType.Cristal ;
                r[2] = resType.Metal ;
            }
            else if ( Deuterium <= Metal && Metal <= Cristal )
            {
                r[0] = resType.Deuterium ;
                r[1] = resType.Metal ;
                r[2] = resType.Cristal ;
            }
            return r ;
        }
        public resType RessourceMajoritaire()
        {
            return triDesRessource()[2] ;
        }
        public resType RessourceMoyenne()
        {
            return triDesRessource()[1] ;
        }
        public resType RessourceMinoritaire()
        {
            return triDesRessource()[0] ;
        }

        private UInt32 _Metal;
        public UInt32 Metal
        {
            get { return _Metal; }
            set { _Metal = value; }
        }
        private UInt32 _Cristal;
        public UInt32 Cristal
        {
            get { return _Cristal; }
            set { _Cristal = value; }
        }
        private UInt32 _Deuterium;
        public UInt32 Deuterium
        {
            get { return _Deuterium; }
            set { _Deuterium = value; }
        }
        private UInt32 _Energie;
        public UInt32 Energie
        {
            get { return _Energie; }
            set { _Energie = value; }
        }

        public UInt32 Total
        {
            get {
                return Metal + Cristal + Deuterium ;
            }
        }

        public UInt32 NombreDeRecycleurs()
        {
            return ( Metal + Cristal + 19999 ) / 20000 ;
        }

        public UInt32 CapaciteNecessairePourPillerLeMax()
        {
            return Math.Max(
                Metal + Cristal + Deuterium,
                Math.Min(
                    (2 * Metal + Cristal + Deuterium) * 3 / 4,
                    (2 * Metal + Deuterium)
                )
            ) ;
        }

        public UInt32 NombreDeGrandsTransporteurs()
        {
            return ( CapaciteNecessairePourPillerLeMax() + 49999 ) / 50000 ;
        }

        public UInt32 NombreDePetitsTransporteurs()
        {
            return ( CapaciteNecessairePourPillerLeMax() + 9999 ) / 10000 ;
        }

        public UInt32 NombreDeVaisseauxDeBataille()
        {
            return ( CapaciteNecessairePourPillerLeMax() + 1499 ) / 1500 ;
        }
    }

    public class RessourcesLong
    {
        public long Metal ;
        public long Cristal ;
        public long Deuterium ;

        public RessourcesLong()
        {
            Metal     = 0 ;
            Cristal   = 0 ;
            Deuterium = 0 ;
        }

        public RessourcesLong(Ressources l)
        {
            Metal     = (long)l.Metal     ;
            Cristal   = (long)l.Cristal   ;
            Deuterium = (long)l.Deuterium ;
        }
        public RessourcesLong(RessourcesLong l)
        {
            Metal     = l.Metal     ;
            Cristal   = l.Cristal   ;
            Deuterium = l.Deuterium ;
        }

        public static RessourcesLong operator+ ( RessourcesLong r1, Ressources r2 ) 
        {
            RessourcesLong r = new RessourcesLong(r1) ;
            r.Metal     += (long)r2.Metal     ;
            r.Cristal   += (long)r2.Cristal   ;
            r.Deuterium += (long)r2.Deuterium ;
            return r ;
        }
        public static RessourcesLong operator+ ( RessourcesLong r1, RessourcesLong r2 ) 
        {
            RessourcesLong r = new RessourcesLong(r1) ;
            r.Metal     += r2.Metal     ;
            r.Cristal   += r2.Cristal   ;
            r.Deuterium += r2.Deuterium ;
            return r ;
        }

        public static RessourcesLong operator- ( RessourcesLong r1 ) 
        {
            RessourcesLong r = new RessourcesLong(r1) ;
            r.Metal     = -r.Metal     ;
            r.Cristal   = -r.Cristal   ;
            r.Deuterium = -r.Deuterium ;
            return r ;
        }
        public static RessourcesLong operator- ( RessourcesLong r1, Ressources r2 ) 
        {
            RessourcesLong r = new RessourcesLong(r1) ;
            r.Metal     -= (long)r2.Metal     ;
            r.Cristal   -= (long)r2.Cristal   ;
            r.Deuterium -= (long)r2.Deuterium ;
            return r ;
        }
        public static RessourcesLong operator- ( RessourcesLong r1, RessourcesLong r2 ) 
        {
            RessourcesLong r = new RessourcesLong(r1) ;
            r.Metal     -= r2.Metal     ;
            r.Cristal   -= r2.Cristal   ;
            r.Deuterium -= r2.Deuterium ;
            return r ;
        }

        public static RessourcesLong operator* ( RessourcesLong r1 , long f )
        {
            RessourcesLong r = new RessourcesLong(r1) ;
            r.Metal     *= f ;
            r.Cristal   *= f ;
            r.Deuterium *= f ;
            return r ;
        }

        public static RessourcesLong operator/ ( RessourcesLong r1 , long f )
        {
            RessourcesLong r = new RessourcesLong(r1) ;
            r.Metal     /= f ;
            r.Cristal   /= f ;
            r.Deuterium /= f ;
            return r ;
        }

        public static RessourcesLong operator/ ( RessourcesLong r1 , double f )
        {
            RessourcesLong r = new RessourcesLong(r1) ;
            r.Metal     = (long)((double)r.Metal    /f) ;
            r.Cristal   = (long)((double)r.Cristal  /f) ;
            r.Deuterium = (long)((double)r.Deuterium/f) ;
            return r ;
        }

        public static RessourcesLong Minimum
        {
            get {
                RessourcesLong r = new RessourcesLong() ;
                r.Cristal   = long.MinValue ;
                r.Metal     = long.MinValue ;
                r.Deuterium = long.MinValue ;
                return r ;
            }
        }
        public static RessourcesLong Maximum
        {
            get {
                RessourcesLong r = new RessourcesLong() ;
                r.Cristal   = long.MaxValue ;
                r.Metal     = long.MaxValue ;
                r.Deuterium = long.MaxValue ;
                return r ;
            }
        }

        public void copie( RessourcesLong r )
        {
            this.Metal = r.Metal ;
            this.Cristal = r.Cristal ;
            this.Deuterium = r.Deuterium ;
        }

        public long Total
        {
            get {
                return Metal + Cristal + Deuterium ;
            }
        }

        public long NombreDeRecycleurs()
        {
            return ( Metal + Cristal + 19999 ) / 20000 ;
        }

        public long CapaciteNecessairePourPillerLeMax()
        {
            return Math.Max(
                Metal + Cristal + Deuterium,
                Math.Min(
                    (2 * Metal + Cristal + Deuterium) * 3 / 4,
                    (2 * Metal + Deuterium)
                )
            ) ;
        }

        public long NombreDeGrandsTransporteurs()
        {
            return ( CapaciteNecessairePourPillerLeMax() + 49999 ) / 50000 ;
        }

        public long NombreDePetitsTransporteurs()
        {
            return ( CapaciteNecessairePourPillerLeMax() + 9999 ) / 10000 ;
        }

        public long NombreDeVaisseauxDeBataille()
        {
            return ( CapaciteNecessairePourPillerLeMax() + 1499 ) / 1500 ;
        }

        public int ProbabiliteDeCreationDeLune()
        {
            return (int)Math.Min((Metal+Cristal)/100000L, 20L) ;
        }

        public static explicit operator Ressources( RessourcesLong rl )
        {
            Ressources r = new Ressources() ;
            r.Metal     = (uint)rl.Metal     ;
            r.Cristal   = (uint)rl.Cristal   ;
            r.Deuterium = (uint)rl.Deuterium ;
            return r ;
        }
    }

    public enum TypeDeCoordonnees
    {
        Planete, Lune, ChampsDeRuines
    }

    [Serializable]
    public class Coordonnees : System.IEquatable<Coordonnees>, IComparable<Coordonnees>
    {
        public int DifferenceDeGalaxies( Coordonnees cible )
        {
            return Math.Abs( (int)this.Galaxie - (int)cible.Galaxie ) ;
        }
        public int DifferenceDeSystemes( Coordonnees cible )
        {
            return Math.Abs( (int)this.Systeme - (int)cible.Systeme ) ;
        }
        public int DifferenceDePlanetes( Coordonnees cible )
        {
            return Math.Abs( (int)this.Planete - (int)cible.Planete ) ;
        }

        public bool Equals(Coordonnees c )
        {
            return 
                this.Galaxie.Equals( c.Galaxie )
             && this.Planete.Equals( c.Planete )
             && this.Systeme.Equals( c.Systeme )
             && this.Type.Equals( c.Type )
            ;
        }

        public int CompareTo( Coordonnees other )
        {
            if ( this.Galaxie != other.Galaxie ) return this.Galaxie-other.Galaxie ;
            if ( this.Systeme != other.Systeme ) return this.Systeme-other.Systeme ;
            return this.Planete-other.Planete ;
        }

        public override int GetHashCode() 
        {
            return ((string)this).GetHashCode() ;
        }

        public int Distance( Coordonnees cible )
        {
            if ( this.Galaxie != cible.Galaxie )
            {
                return Math.Abs( (int)this.Galaxie - (int)cible.Galaxie ) * 20000 ;
            }
            if ( this.Systeme != cible.Systeme )
            {
                return Math.Abs( (int)this.Systeme - (int)cible.Systeme ) * 95 + 2700  ;
            }
            if ( this.Planete != cible.Planete )
            {
                return Math.Abs( (int)this.Planete - (int)cible.Planete ) * 5 + 1000 ;
            }
            //TODO: vers sa propre lune ou son propre champs de ruines
            return 0 ;
        }

        String Cherche( string source, string regex )
        {
            Regex r = new Regex( regex, RegexOptions.IgnoreCase );
            Match m = r.Match( source );
            if ( m.Success )
            {
                return m.Groups[1].Value;
            }
            throw new Exception("Format de coordonnée non valide.") ;
        }

        public static implicit operator Coordonnees( String c )
        {
            return new Coordonnees( c );
        }

        public Coordonnees()
        {
            Galaxie = 1;
            Systeme = 1;
            Planete = 1;
            Type = TypeDeCoordonnees.Planete;
        }
        public Coordonnees( Coordonnees c )
        {
            this._Galaxie = c._Galaxie ;
            this._Planete = c._Planete ;
            this._Systeme = c._Systeme ;
            this._Type = c._Type ;
        }
        public Coordonnees( string coords )
        {
            Galaxie = System.Convert.ToUInt16( Cherche( coords, @"^\[?(\d{1,3})[:.]\d{1,3}[:.]\d{1,2}\]?(\([LD]\))?$" ) );
            Systeme = System.Convert.ToUInt16( Cherche( coords, @"^\[?\d{1,3}[:.](\d{1,3})[:.]\d{1,2}\]?(\([LD]\))?$" ) );
            Planete = System.Convert.ToUInt16( Cherche( coords, @"^\[?\d{1,3}[:.]\d{1,3}[:.](\d{1,2})\]?(\([LD]\))?$" ) );
            Type = TypeDeCoordonnees.Planete;
        }
        public Coordonnees( UInt16 galaxie, UInt16 systeme, UInt16 planete )
        {
            this.Galaxie = galaxie;
            this.Systeme = systeme;
            this.Planete = planete;
            Type = TypeDeCoordonnees.Planete;
        }
        public Coordonnees( string coords, TypeDeCoordonnees Type )
        {
            Galaxie = System.Convert.ToUInt16( Cherche( coords, @"^\[?(\d{1,3})[:.]\d{1,3}[:.]\d{1,2}\]?(\([LD]\))?$" ) );
            Systeme = System.Convert.ToUInt16( Cherche( coords, @"^\[?\d{1,3}[:.](\d{1,3})[:.]\d{1,2}\]?(\([LD]\))?$" ) );
            Planete = System.Convert.ToUInt16( Cherche( coords, @"^\[?\d{1,3}[:.]\d{1,3}[:.](\d{1,2})\]?(\([LD]\))?$" ) );
            this.Type = Type;
        }
        public Coordonnees( UInt16 galaxie, UInt16 systeme, UInt16 planete, TypeDeCoordonnees Type )
        {
            this.Galaxie = galaxie;
            this.Systeme = systeme;
            this.Planete = planete;
            this.Type = Type;
        }
        private TypeDeCoordonnees _Type;
        public TypeDeCoordonnees Type
        {
            get { return _Type; }
            set
            {
                _Type = value;
            }
        }
        private UInt16 _Galaxie;
        public UInt16 Galaxie
        {
            get { return _Galaxie; }
            set
            {
                if ( value >= 1 && value <= Valeurs.maxGalaxie )
                    _Galaxie = value;
                else
                    throw new ArgumentOutOfRangeException( "Galaxie", "Une Galaxie doit etre comprise entre 1 et "+Valeurs.maxGalaxie+" (est " + value + ")" );
            }
        }
        private UInt16 _Systeme;
        public UInt16 Systeme
        {
            get { return _Systeme; }
            set
            {
                if ( value >= 1 && value <= Valeurs.maxSysteme )
                    _Systeme = value;
                else
                    throw new ArgumentOutOfRangeException( "Systeme", "Un Systeme doit etre compris entre 1 et "+Valeurs.maxSysteme+" (est " + value + ")" );
            }
        }
        private UInt16 _Planete;
        public UInt16 Planete
        {
            get { return _Planete; }
            set
            {
                if ( value >= 1 && value <= Valeurs.maxPlanete )
                    _Planete = value;
                else
                    throw new ArgumentOutOfRangeException( "Planete", "Une Planete doit etre comprise entre 1 et "+Valeurs.maxPlanete+" (est " + value + ")" );
            }
        }
        public static implicit operator String(Coordonnees c)
        {
            String r = System.Convert.ToString( c.Galaxie ) + ":" + c.Systeme + ":" + c.Planete;
            switch ( c.Type )
            {
                case TypeDeCoordonnees.ChampsDeRuines :
                    r += "(D)";
                    break;
                case TypeDeCoordonnees.Lune :
                    r += "(L)";
                    break;
            }
            return r ;
        }

    }

    [Serializable]
    public class Batiments
    {
        private bool _EstSurUneLune;
        public bool EstSurUneLune
        {
            get { return _EstSurUneLune ; }
            set
            {
                //TODO: test de cohérence...
                _EstSurUneLune = value ;
            }
        }
        public Batiments()
        {
            _EstSurUneLune = false; 
        }
        public Batiments( bool EstSurUneLune )
        {
            this._EstSurUneLune = EstSurUneLune;
        }
        public Batiments( Batiments b )
        {
            this._BaseLunaire = b._BaseLunaire ;
            this._CentraleFusion = b._CentraleFusion ;
            this._CentraleSolaire = b._CentraleSolaire ;
            this._ChantierSpatial = b._ChantierSpatial ;
            this._EstSurUneLune = b._EstSurUneLune ;
            this._HangarDeCristal = b._HangarDeCristal ;
            this._HangarDeMetal = b._HangarDeMetal ;
            this._LaboratoireDeRecherche = b._LaboratoireDeRecherche ;
            this._MineDeCristal = b._MineDeCristal ;
            this._MineDeMetal = b._MineDeMetal ;
            this._PhalangeDeCapteur = b._PhalangeDeCapteur ;
            this._PorteDeSautSpatial = b._ReservoirDeDeuterium ;
            this._SiloDeMissiles = b._SiloDeMissiles ;
            this._SynthetiseurDeDeuterium = b._SynthetiseurDeDeuterium ;
            this._Terraformeur = b._Terraformeur ;
            this._UsineDeNanites = b._UsineDeNanites ;
            this._UsineDeRobots = b._UsineDeRobots ;
        }

        private UInt32 _MineDeMetal;
        public UInt32 MineDeMetal
        {
            get { if ( this._EstSurUneLune ) return 0; return _MineDeMetal; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une lune ne peut pas avoir de mine de métal" );
                _MineDeMetal = value;
            }
        }
        private UInt32 _MineDeCristal;
        public UInt32 MineDeCristal
        {
            get { if ( this._EstSurUneLune ) return 0; return _MineDeCristal; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une lune ne peut pas avoir de mine de cristal" );
                _MineDeCristal = value;
            }
        }
        private UInt32 _SynthetiseurDeDeuterium;
        public UInt32 SynthetiseurDeDeuterium
        {
            get { if ( this._EstSurUneLune ) return 0; return _SynthetiseurDeDeuterium; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une lune ne peut pas avoir de synthétiseur de deutérium" );
                _SynthetiseurDeDeuterium = value;
            }
        }
        private UInt32 _CentraleSolaire;
        public UInt32 CentraleSolaire
        {
            get { if ( this._EstSurUneLune ) return 0; return _CentraleSolaire; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une lune ne peut pas avoir de centrale solaire" );
                _CentraleSolaire = value;
            }
        }
        private UInt32 _CentraleFusion;
        public UInt32 CentraleFusion
        {
            get { if ( this._EstSurUneLune ) return 0; return _CentraleFusion; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une lune ne peut pas avoir de centrale à fusion" );
                _CentraleFusion = value;
            }
        }
        private UInt32 _UsineDeRobots;
        public UInt32 UsineDeRobots
        {
            get { return _UsineDeRobots; }
            set { _UsineDeRobots = value; }
        }
        private UInt32 _UsineDeNanites;
        public UInt32 UsineDeNanites
        {
            get { if ( this._EstSurUneLune ) return 0; return _UsineDeNanites; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une lune ne peut pas avoir d'usine de nanites" );
                _UsineDeNanites = value;
            }
        }
        private UInt32 _ChantierSpatial;
        public UInt32 ChantierSpatial
        {
            get { return _ChantierSpatial; }
            set { _ChantierSpatial = value; }
        }
        private UInt32 _HangarDeMetal;
        public UInt32 HangarDeMetal
        {
            get { return _HangarDeMetal; }
            set { _HangarDeMetal = value; }
        }
        private UInt32 _HangarDeCristal;
        public UInt32 HangarDeCristal
        {
            get { return _HangarDeCristal; }
            set { _HangarDeCristal = value; }
        }
        private UInt32 _ReservoirDeDeuterium;
        public UInt32 ReservoirDeDeuterium
        {
            get { return _ReservoirDeDeuterium; }
            set { _ReservoirDeDeuterium = value; }
        }
        private UInt32 _LaboratoireDeRecherche;
        public UInt32 LaboratoireDeRecherche
        {
            get { return _LaboratoireDeRecherche; }
            set { _LaboratoireDeRecherche = value; }
        }
        private UInt32 _Terraformeur;
        public UInt32 Terraformeur
        {
            get { if ( this._EstSurUneLune ) return 0; return _Terraformeur; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une lune ne peut pas avoir de terraformeur" );
                _Terraformeur = value;
            }
        }
        private UInt32 _SiloDeMissiles;
        public UInt32 SiloDeMissiles
        {
            get { if ( this._EstSurUneLune ) return 0; return _SiloDeMissiles; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une lune ne peut pas avoir de silos à missiles" );
                _SiloDeMissiles = value;
            }
        }
        private UInt32 _BaseLunaire;
        public UInt32 BaseLunaire
        {
            get { if ( !this._EstSurUneLune ) return 0; return _BaseLunaire; }
            set
            {
                if ( !_EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une planète ne peut pas avoir de base lunaire" );
                _BaseLunaire = value;
            }
        }
        private UInt32 _PhalangeDeCapteur;
        public UInt32 PhalangeDeCapteur
        {
            get { if ( !this._EstSurUneLune ) return 0; return _PhalangeDeCapteur; }
            set
            {
                if ( !_EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une planète ne peut pas avoir de phalange de capteur" );
                _PhalangeDeCapteur = value;
            }
        }
        private UInt32 _PorteDeSautSpatial;
        public UInt32 PorteDeSautSpatial
        {
            get { if ( !this._EstSurUneLune ) return 0; return _PorteDeSautSpatial; }
            set
            {
                if ( !_EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une planète ne peut pas avoir de porte de saut spatial" );
                _PorteDeSautSpatial = value;
            }
        }
    }

    [Serializable]
    public class Flotte
    {
        public Technologie recherchesAssociees ;

        private bool EstUneFlotteAttaquante;
        public bool estVide()
        {
            return
                this._Bombardiers == 0
            &&  this._ChasseursLegers == 0
            &&  this._ChasseursLourds == 0
            &&  this._Croiseurs == 0
            &&  this._Destructeurs == 0
            &&  this._Battlecruiser == 0
            &&  this._EtoilesDeLaMort == 0
            &&  this._GrandsTransporteurs == 0
            &&  this._PetitsTransporteurs == 0
            &&  this._Recycleurs == 0
            &&  this._SatellitesSolaires == 0
            &&  this._SondesDEspionnage == 0
            &&  this._VaisseauxDeBataille == 0
            &&  this._VaisseauxDeColonisation == 0
            ;
        }
        public Flotte()
        {
            _CoordonneesDeDepart = new Coordonnees() ;
            RatioVitesseFlotte = 100 ;
            EstUneFlotteAttaquante = false;
        }
        public Flotte( bool EstUneFlotteAttaquante )
        {
            _CoordonneesDeDepart = new Coordonnees() ;
            RatioVitesseFlotte = 100 ;
            this.EstUneFlotteAttaquante = EstUneFlotteAttaquante;
        }
        public Flotte( Flotte f )
        {
            this._Bombardiers = f._Bombardiers ;
            this._ChasseursLegers = f._ChasseursLegers ;
            this._ChasseursLourds = f._ChasseursLourds ;
            this._CoordonneesDeDepart = f._CoordonneesDeDepart ;
            this._Croiseurs = f._Croiseurs ;
            this._Destructeurs = f._Destructeurs ;
            this._Battlecruiser = f._Battlecruiser ;
            this._EtoilesDeLaMort = f._EtoilesDeLaMort ;
            this._GrandsTransporteurs = f._GrandsTransporteurs ;
            this._PetitsTransporteurs = f._PetitsTransporteurs ;
            this._Recycleurs = f._Recycleurs ;
            this._SatellitesSolaires = f._SatellitesSolaires ;
            this._SondesDEspionnage = f._SondesDEspionnage ;
            this._VaisseauxDeBataille = f._VaisseauxDeBataille ;
            this._VaisseauxDeColonisation = f._VaisseauxDeColonisation ;
            this._RatioVitesseFlotte = f._RatioVitesseFlotte ;
        }

        public static Flotte operator+( Flotte f1, Flotte f2 )
        {
            Flotte f = new Flotte(f1) ;
            f.Bombardiers += f2.Bombardiers ;
            f.ChasseursLegers += f2.ChasseursLegers ;
            f.ChasseursLourds += f2.ChasseursLourds ;
            f.Croiseurs += f2.Croiseurs ;
            f.Destructeurs += f2.Destructeurs ;
            f.Battlecruiser += f2.Battlecruiser ;
            f.EtoilesDeLaMort += f2.EtoilesDeLaMort ;
            f.GrandTransporteurs += f2.GrandTransporteurs ;
            f.PetitsTransporteurs += f2.PetitsTransporteurs ;
            f.Recycleurs += f2.Recycleurs ;
            f.SatellitesSolaires += f2.SatellitesSolaires ;
            f.SondesDEspionnage += f2.SondesDEspionnage ;
            f.VaisseauxDeBataille += f2.VaisseauxDeBataille ;
            f.VaisseauxDeColonisation += f2.VaisseauxDeColonisation ;
            return f ;
        }

        public static Flotte operator-( Flotte f1, Flotte f2 )
        {
            Flotte f = new Flotte(f1) ;
            if ( f.Bombardiers > f2.Bombardiers )
                f.Bombardiers -= f2.Bombardiers ;
            else
                f.Bombardiers = 0 ;
            if ( f.ChasseursLegers > f2.ChasseursLegers )
                f.ChasseursLegers -= f2.ChasseursLegers ;
            else
                f.ChasseursLegers = 0 ;
            if ( f.ChasseursLourds > f2.ChasseursLourds )
                f.ChasseursLourds -= f2.ChasseursLourds ;
            else
                f.ChasseursLourds = 0 ;
            if ( f.Croiseurs > f2.Croiseurs )
                f.Croiseurs -= f2.Croiseurs ;
            else
                f.Croiseurs = 0 ;
            if ( f.Destructeurs > f2.Destructeurs )
                f.Destructeurs -= f2.Destructeurs ;
            else
                f.Destructeurs = 0 ;
            if ( f.Battlecruiser > f2.Battlecruiser )
                f.Battlecruiser -= f2.Battlecruiser ;
            else
                f.Battlecruiser = 0 ;
            if ( f.EtoilesDeLaMort > f2.EtoilesDeLaMort )
                f.EtoilesDeLaMort -= f2.EtoilesDeLaMort ;
            else
                f.EtoilesDeLaMort = 0 ;
            if ( f.GrandTransporteurs > f2.GrandTransporteurs )
                f.GrandTransporteurs -= f2.GrandTransporteurs ;
            else
                f.GrandTransporteurs = 0 ;
            if ( f.PetitsTransporteurs > f2.PetitsTransporteurs )
                f.PetitsTransporteurs -= f2.PetitsTransporteurs ;
            else
                f.PetitsTransporteurs = 0 ;
            if ( f.Recycleurs > f2.Recycleurs )
                f.Recycleurs -= f2.Recycleurs ;
            else
                f.Recycleurs = 0 ;
            if ( f.SatellitesSolaires > f2.SatellitesSolaires )
                f.SatellitesSolaires -= f2.SatellitesSolaires ;
            else
                f.SatellitesSolaires = 0 ;
            if ( f.SondesDEspionnage > f2.SondesDEspionnage )
                f.SondesDEspionnage -= f2.SondesDEspionnage ;
            else
                f.SondesDEspionnage = 0 ;
            if ( f.VaisseauxDeBataille > f2.VaisseauxDeBataille )
                f.VaisseauxDeBataille -= f2.VaisseauxDeBataille ;
            else
                f.VaisseauxDeBataille = 0 ;
            if ( f.VaisseauxDeColonisation > f2.VaisseauxDeColonisation )
                f.VaisseauxDeColonisation -= f2.VaisseauxDeColonisation ;
            else
                f.VaisseauxDeColonisation = 0 ;
            return f ;
        }

        public static Flotte operator*( Flotte f1, int i )
        {
            Flotte f = new Flotte(f1) ;
            if ( i > 0 )
            {
                f.Bombardiers             *= (uint)i ;
                f.ChasseursLegers         *= (uint)i ;
                f.ChasseursLourds         *= (uint)i ;
                f.Croiseurs               *= (uint)i ;
                f.Destructeurs            *= (uint)i ;
                f.Battlecruiser           *= (uint)i ;
                f.EtoilesDeLaMort         *= (uint)i ;
                f.GrandTransporteurs      *= (uint)i ;
                f.PetitsTransporteurs     *= (uint)i ;
                f.Recycleurs              *= (uint)i ;
                f.SatellitesSolaires      *= (uint)i ;
                f.SondesDEspionnage       *= (uint)i ;
                f.VaisseauxDeBataille     *= (uint)i ;
                f.VaisseauxDeColonisation *= (uint)i ;
            }
            return f ;
        }

        public Ressources ValeurDAchat()
        {
            UInt32 Metal   = 0 ;
            UInt32 Cristal = 0 ;
            UInt32 Deut    = 0 ;
            Metal   += PetitsTransporteurs * 2000 ;
            Cristal += PetitsTransporteurs * 2000 ;
            Metal   += GrandTransporteurs * 6000 ;
            Cristal += GrandTransporteurs * 6000 ;
            Metal   += ChasseursLegers * 3000 ;
            Cristal += ChasseursLegers * 1000 ;
            Metal   += ChasseursLourds * 6000 ;
            Cristal += ChasseursLourds * 4000 ;
            Metal   += Croiseurs * 20000 ;
            Cristal += Croiseurs *  7000 ;
            Deut    += Croiseurs *  2000 ;
            Metal   += VaisseauxDeBataille * 45000 ;
            Cristal += VaisseauxDeBataille * 15000 ;
            Metal   += VaisseauxDeColonisation * 10000 ;
            Cristal += VaisseauxDeColonisation * 20000 ;
            Deut    += VaisseauxDeColonisation * 10000 ;
            Metal   += Recycleurs * 10000 ;
            Cristal += Recycleurs *  6000 ;
            Deut    += Recycleurs *  2000 ;
            Cristal += SondesDEspionnage * 1500 ;
            Metal   += Bombardiers * 50000 ;
            Cristal += Bombardiers * 25000 ;
            Deut    += Bombardiers * 15000 ;
            Cristal += SatellitesSolaires * 2000 ;
            Deut    += SatellitesSolaires *  500 ;
            Metal   += Destructeurs * 60000 ;
            Cristal += Destructeurs * 50000 ;
            Deut    += Destructeurs * 15000 ;
            Metal   += Battlecruiser * 30000 ;
            Cristal += Battlecruiser * 40000 ;
            Deut    += Battlecruiser * 15000 ;
            Metal   += EtoilesDeLaMort * 5000000 ;
            Cristal += EtoilesDeLaMort * 4000000 ;
            Deut    += EtoilesDeLaMort * 1000000 ;
            Ressources r = new Ressources() ;
            r.Metal     = Metal   ;
            r.Cristal   = Cristal ;
            r.Deuterium = Deut    ;
            return r ;
        }

        public Ressources ValeurEnRuines()
        {
            UInt32 Metal   = 0 ;
            UInt32 Cristal = 0 ;
            Metal   += PetitsTransporteurs * 600 ;
            Cristal += PetitsTransporteurs * 600 ;
            Metal   += GrandTransporteurs * 1800 ;
            Cristal += GrandTransporteurs * 1800 ;
            Metal   += ChasseursLegers * 900 ;
            Cristal += ChasseursLegers * 300 ;
            Metal   += ChasseursLourds * 1800 ;
            Cristal += ChasseursLourds * 1200 ;
            Metal   += Croiseurs * 6000 ;
            Cristal += Croiseurs * 2100 ;
            Metal   += VaisseauxDeBataille * 13500 ;
            Cristal += VaisseauxDeBataille *  4500 ;
            Metal   += VaisseauxDeColonisation * 3000 ;
            Cristal += VaisseauxDeColonisation * 6000 ;
            Metal   += Recycleurs * 3000 ;
            Cristal += Recycleurs * 1800 ;
            Metal   += SondesDEspionnage *   0 ;
            Cristal += SondesDEspionnage * 300 ;
            Metal   += Bombardiers * 15000 ;
            Cristal += Bombardiers *  7500 ;
            Metal   += SatellitesSolaires *   0 ;
            Cristal += SatellitesSolaires * 600 ;
            Metal   += Destructeurs * 18000 ;
            Cristal += Destructeurs * 15000 ;
            Metal   += Battlecruiser *  9000 ;
            Cristal += Battlecruiser * 12000 ;
            Metal   += EtoilesDeLaMort * 1500000 ;
            Cristal += EtoilesDeLaMort * 1200000 ;
            Ressources r = new Ressources() ;
            r.Metal     = Metal   ;
            r.Cristal   = Cristal ;
            return r ;
        }

        private Coordonnees _CoordonneesDeDepart ;
        public Coordonnees CoordonneesDeDepart
        {
            get { return _CoordonneesDeDepart; }
            set { _CoordonneesDeDepart = value; }
        }

        private UInt32 _PetitsTransporteurs;
        public UInt32 PetitsTransporteurs
        {
            get { return _PetitsTransporteurs; }
            set { _PetitsTransporteurs = value; }
        }
        private UInt32 _GrandsTransporteurs;
        public UInt32 GrandTransporteurs
        {
            get { return _GrandsTransporteurs; }
            set { _GrandsTransporteurs = value; }
        }
        private UInt32 _ChasseursLegers;
        public UInt32 ChasseursLegers
        {
            get { return _ChasseursLegers; }
            set { _ChasseursLegers = value; }
        }
        private UInt32 _ChasseursLourds;
        public UInt32 ChasseursLourds
        {
            get { return _ChasseursLourds; }
            set { _ChasseursLourds = value; }
        }
        private UInt32 _Croiseurs;
        public UInt32 Croiseurs
        {
            get { return _Croiseurs; }
            set { _Croiseurs = value; }
        }
        private UInt32 _VaisseauxDeBataille;
        public UInt32 VaisseauxDeBataille
        {
            get { return _VaisseauxDeBataille; }
            set { _VaisseauxDeBataille = value; }
        }
        private UInt32 _VaisseauxDeColonisation;
        public UInt32 VaisseauxDeColonisation
        {
            get { return _VaisseauxDeColonisation; }
            set { _VaisseauxDeColonisation = value; }
        }
        private UInt32 _Recycleurs;
        public UInt32 Recycleurs
        {
            get { return _Recycleurs; }
            set { _Recycleurs = value; }
        }
        private UInt32 _SondesDEspionnage;
        public UInt32 SondesDEspionnage
        {
            get { return _SondesDEspionnage; }
            set { _SondesDEspionnage = value; }
        }
        private UInt32 _Bombardiers;
        public UInt32 Bombardiers
        {
            get { return _Bombardiers; }
            set { _Bombardiers = value; }
        }
        private UInt32 _SatellitesSolaires;
        public UInt32 SatellitesSolaires
        {
            get { if ( EstUneFlotteAttaquante ) return 0; return _SatellitesSolaires; }
            set { if ( EstUneFlotteAttaquante && (value != 0) ) throw new Exception("Une flotte attaquante ne peut pas contenir de satellites solaires.") ;_SatellitesSolaires = value; }
        }
        private UInt32 _Destructeurs;
        public UInt32 Destructeurs
        {
            get { return _Destructeurs; }
            set { _Destructeurs = value; }
        }
        private UInt32 _Battlecruiser;
        public UInt32 Battlecruiser
        {
            get { return _Battlecruiser; }
            set { _Battlecruiser = value; }
        }
        private UInt32 _EtoilesDeLaMort;
        public UInt32 EtoilesDeLaMort
        {
            get { return _EtoilesDeLaMort; }
            set { _EtoilesDeLaMort = value; }
        }

        public uint Nombre
        {
            get
            {
                return 0
                + PetitsTransporteurs
                + GrandTransporteurs
                + ChasseursLegers
                + ChasseursLourds
                + Croiseurs
                + VaisseauxDeBataille
                + VaisseauxDeColonisation
                + Recycleurs
                + SondesDEspionnage
                + Bombardiers
                + SatellitesSolaires
                + Destructeurs
                + Battlecruiser
                + EtoilesDeLaMort
                ;
            }
        }

        private enum propulsion
        {
            Combustion  ,
            Impulsion   ,
            Hyperespaces
        } ;

        static private int[,] tableDesCaracteristiques = new int[,]
        {
/* Caractéristique*//*     vitesse  consommation    Soute */
                    /*           0             1        2 */
/*             0 PT */{       5000,           10,    5000 }, // /!\ Dépend du niveau !
/*             1 GT */{       7500,           50,   25000 },
/*             2 Cl */{      12500,           20,      50 },
/*             3 CL */{      10000,           75,     100 },
/*             4 CR */{      15000,          300,     800 },
/*             5 VB */{      10000,          500,    1500 },
/*             6 VC */{       2500,         1000,    7500 },
/*             7 RC */{       2000,          300,   20000 },
/*             8 SE */{  100000000,            1,       5 }, // /!\ Attention aux sondes, elles ne peuvent porter que ce qu'elles consomment.
/*             9 SS */{          0,            0,       0 },
/*            10 BB */{       5000,         1000,     500 },
/*            11 DS */{       5000,         1000,    2000 }, // /!\ Dépend du niveau !
/*            12 BC */{      10000,          250,     750 },
/*            13 EM */{        100,            1, 1000000 }
        } ;

        private double consoVaisseau( int distance, int vitesse, UInt32 nombreDeVaisseaux, int vitesseDesVaisseaux, int consommationDesVaisseaux )
        {
            if ( vitesseDesVaisseaux == 0 ) return 0.0f ;
            double spd = 35000.0f / ( vitesse - 10 ) * Math.Sqrt( distance * 10 / (double)vitesseDesVaisseaux ) ;
            double bc = consommationDesVaisseaux * nombreDeVaisseaux ;
            return bc * ( spd/10 + 1 ) * ( spd/10 + 1 ) ;
        }

        // Calcule la consommation pour un trajet de distance, aller simple.
        public Ressources Consommation( Coordonnees cible, int pourcentageDeVitesse ) 
        {
            if ( estVide() ) return new Ressources() ;
            UInt64 conso = 0;
            int distance = this.CoordonneesDeDepart.Distance( cible ) ;
            int tempsTrajet = (int)TempsDeTrajet(cible) ; // this.Vitesse ;
            // Vaisseaux : (exemple petits transporteurs)
            // - nombre : this.PetitsTransporteurs
            // - vitesse : 
            #region Calcule la vitesse de chaque type de vaisseaux
            int vPetitsTransporteurs     = 0 ;
            int vGrandTransporteurs      = 0 ;
            int vChasseursLegers         = 0 ;
            int vChasseursLourds         = 0 ;
            int vCroiseurs               = 0 ;
            int vVaisseauxDeBataille     = 0 ;
            int vVaisseauxDeColonisation = 0 ;
            int vRecycleurs              = 0 ;
            int vSondesDEspionnage       = 0 ;
            int vSatellitesSolaires      = 0 ;
            int vBombardiers             = 0 ;
            int vDestructeurs            = 0 ;
            int vTraqueurs               = 0 ;
            int vEtoilesDeLaMort         = 0 ;
            if ( recherchesAssociees != null )
            {
                vPetitsTransporteurs     = (int)(tableDesCaracteristiques[ 0, 0] * ( 10 +     recherchesAssociees.ReacteurACombustion   ) / 10 ) ; 
                vGrandTransporteurs      = (int)(tableDesCaracteristiques[ 1, 0] * ( 10 +     recherchesAssociees.ReacteurACombustion   ) / 10 ) ; 
                vChasseursLegers         = (int)(tableDesCaracteristiques[ 2, 0] * ( 10 +     recherchesAssociees.ReacteurACombustion   ) / 10 ) ; 
                vChasseursLourds         = (int)(tableDesCaracteristiques[ 3, 0] * ( 10 +     recherchesAssociees.ReacteurACombustion   ) / 10 ) ; 
                vCroiseurs               = (int)(tableDesCaracteristiques[ 4, 0] * ( 10 + 2 * recherchesAssociees.ReacteurAImpulsion    ) / 10 ) ; 
                vVaisseauxDeBataille     = (int)(tableDesCaracteristiques[ 5, 0] * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ; 
                vVaisseauxDeColonisation = (int)(tableDesCaracteristiques[ 6, 0] * ( 10 + 2 * recherchesAssociees.ReacteurAImpulsion    ) / 10 ) ; 
                vRecycleurs              = (int)(tableDesCaracteristiques[ 7, 0] * ( 10 +     recherchesAssociees.ReacteurACombustion   ) / 10 ) ; 
                vSondesDEspionnage       = (int)(tableDesCaracteristiques[ 8, 0] * ( 10 +     recherchesAssociees.ReacteurACombustion   ) / 10 ) ; 
                vSatellitesSolaires      = (int)(tableDesCaracteristiques[ 9, 0]                                                               ) ;
                vBombardiers             = (int)(tableDesCaracteristiques[10, 0] * ( 10 + 2 * recherchesAssociees.ReacteurAImpulsion    ) / 10 ) ; 
                vDestructeurs            = (int)(tableDesCaracteristiques[11, 0] * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ; 
                vTraqueurs               = (int)(tableDesCaracteristiques[12, 0] * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ;
                vEtoilesDeLaMort         = (int)(tableDesCaracteristiques[13, 0] * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ; 
                if ( recherchesAssociees.ReacteurAImpulsion >= 5 )
                {
                    vPetitsTransporteurs = (int)(tableDesCaracteristiques[ 0, 0]*2 * ( 10 + 2 * recherchesAssociees.ReacteurAImpulsion    ) / 10 ) ; 
                }
                if ( recherchesAssociees.PropulsionHyperespace >= 8 )
                {
                    vBombardiers         = (int)(5000 * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ; 
                }
            }
            else
            {
                vPetitsTransporteurs     = tableDesCaracteristiques[ 0, 0] ; 
                vGrandTransporteurs      = tableDesCaracteristiques[ 1, 0] ; 
                vChasseursLegers         = tableDesCaracteristiques[ 2, 0] ; 
                vChasseursLourds         = tableDesCaracteristiques[ 3, 0] ; 
                vCroiseurs               = tableDesCaracteristiques[ 4, 0] ; 
                vVaisseauxDeBataille     = tableDesCaracteristiques[ 5, 0] ; 
                vVaisseauxDeColonisation = tableDesCaracteristiques[ 6, 0] ; 
                vRecycleurs              = tableDesCaracteristiques[ 7, 0] ; 
                vSondesDEspionnage       = tableDesCaracteristiques[ 8, 0] ; 
                vSatellitesSolaires      = tableDesCaracteristiques[ 9, 0] ; 
                vBombardiers             = tableDesCaracteristiques[10, 0] ; 
                vDestructeurs            = tableDesCaracteristiques[11, 0] ; 
                vTraqueurs               = tableDesCaracteristiques[12, 0] ; 
                vEtoilesDeLaMort         = tableDesCaracteristiques[13, 0] ;
            }

            #endregion
            // - consommation :
            // dans le tableau !
            double consoPetitsTransporteurs     = consoVaisseau(distance, tempsTrajet, this.PetitsTransporteurs    , vPetitsTransporteurs    , (recherchesAssociees.ReacteurAImpulsion >= 5)?(tableDesCaracteristiques[ 0,1]*2):(tableDesCaracteristiques[ 0,1]) ) ;
            double consoGrandTransporteurs      = consoVaisseau(distance, tempsTrajet, this.GrandTransporteurs     , vGrandTransporteurs     , tableDesCaracteristiques[ 1,1] ) ;
            double consoChasseursLegers         = consoVaisseau(distance, tempsTrajet, this.ChasseursLegers        , vChasseursLegers        , tableDesCaracteristiques[ 2,1] ) ;
            double consoChasseursLourds         = consoVaisseau(distance, tempsTrajet, this.ChasseursLourds        , vChasseursLourds        , tableDesCaracteristiques[ 3,1] ) ;
            double consoCroiseurs               = consoVaisseau(distance, tempsTrajet, this.Croiseurs              , vCroiseurs              , tableDesCaracteristiques[ 4,1] ) ;
            double consoVaisseauxDeBataille     = consoVaisseau(distance, tempsTrajet, this.VaisseauxDeBataille    , vVaisseauxDeBataille    , tableDesCaracteristiques[ 5,1] ) ;
            double consoVaisseauxDeColonisation = consoVaisseau(distance, tempsTrajet, this.VaisseauxDeColonisation, vVaisseauxDeColonisation, tableDesCaracteristiques[ 6,1] ) ;
            double consoRecycleurs              = consoVaisseau(distance, tempsTrajet, this.Recycleurs             , vRecycleurs             , tableDesCaracteristiques[ 7,1] ) ;
            double consoSondesDEspionnage       = consoVaisseau(distance, tempsTrajet, this.SondesDEspionnage      , vSondesDEspionnage      , tableDesCaracteristiques[ 8,1] ) ;
            double consoSatellitesSolaires      = consoVaisseau(distance, tempsTrajet, this.SatellitesSolaires     , vSatellitesSolaires     , tableDesCaracteristiques[ 9,1] ) ;
            double consoBombardiers             = consoVaisseau(distance, tempsTrajet, this.Bombardiers            , vBombardiers            , tableDesCaracteristiques[10,1] ) ;
            double consoDestructeurs            = consoVaisseau(distance, tempsTrajet, this.Destructeurs           , vDestructeurs           , tableDesCaracteristiques[11,1] ) ;
            double consoTraqueur                = consoVaisseau(distance, tempsTrajet, this.Battlecruiser          , vTraqueurs              , tableDesCaracteristiques[12,1] ) ;
            double consoEtoilesDeLaMort         = consoVaisseau(distance, tempsTrajet, this.EtoilesDeLaMort        , vEtoilesDeLaMort        , tableDesCaracteristiques[13,1] ) ;
            conso = (UInt64)( 0
            + consoPetitsTransporteurs    
            + consoGrandTransporteurs     
            + consoChasseursLegers        
            + consoChasseursLourds        
            + consoCroiseurs              
            + consoVaisseauxDeBataille    
            + consoVaisseauxDeColonisation
            + consoRecycleurs             
            + consoSondesDEspionnage      
            + consoSatellitesSolaires     
            + consoBombardiers            
            + consoDestructeurs           
            + consoTraqueur               
            + consoEtoilesDeLaMort        
            ) ; // somme des consommations des différents types de vaisseaux

            Ressources c = new Ressources() ;
            c.Deuterium = (uint)(conso * (UInt64)distance / 35000 + 1) ;
            return c ;
        }

        public long TempsDeTrajet( Coordonnees cible )
        {
            if ( estVide() ) return 0 ;
            //log.Debug("TempsDeTrajet() : RatioVitesseFlotte = " + RatioVitesseFlotte ) ;
            if ( CoordonneesDeDepart.Galaxie != cible.Galaxie )
            {
                return (long)Math.Truncate( 10 + (35000.0f / RatioVitesseFlotte * Math.Sqrt( CoordonneesDeDepart.DifferenceDeGalaxies(cible) * 20000000.0f / this.Vitesse ) ) ) ;
            }
            if ( CoordonneesDeDepart.Systeme != cible.Systeme )
            {
                return (long)Math.Truncate( 10 + (35000.0f / RatioVitesseFlotte * Math.Sqrt( (CoordonneesDeDepart.DifferenceDeSystemes(cible) * 95000.0f + 2700000.0f) / this.Vitesse ) ) ) ;
            }
            if ( CoordonneesDeDepart.Planete != cible.Planete )
            {
                return (long)Math.Truncate( 10 + (35000.0f / RatioVitesseFlotte * Math.Sqrt( (CoordonneesDeDepart.DifferenceDePlanetes(cible) * 5000.0f + 1000000.0f) / this.Vitesse ) ) ) ;
            }
            return (long)Math.Truncate( 10 + (35000.0f / RatioVitesseFlotte * Math.Sqrt( 5000.0f / this.Vitesse ) ) ) ;
        }


        private int _RatioVitesseFlotte ;
        public int RatioVitesseFlotte
        {
            get {
                if ( _RatioVitesseFlotte % 10 != 0 || _RatioVitesseFlotte > 100 || _RatioVitesseFlotte < 10 )
                    _RatioVitesseFlotte = 100 ;
                return _RatioVitesseFlotte ;
            }
            set {
                if ( value % 10 != 0 || value > 100 || value < 10 )
                    _RatioVitesseFlotte = 100 ;
                _RatioVitesseFlotte = value ;
            }
        }

        public int Vitesse
        {
            get {
                if ( estVide() ) return 0 ;
                long v = long.MaxValue ;
                if ( recherchesAssociees != null )
                {
                    if ( recherchesAssociees.ReacteurAImpulsion >= 5 )
                    {
                        if ( PetitsTransporteurs     != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 0, 0] * ( 10 + recherchesAssociees.ReacteurACombustion ) / 10 ) ; 
                    }
                    else
                    {
                        if ( PetitsTransporteurs     != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 0, 0] * ( 10 + 2 * recherchesAssociees.ReacteurAImpulsion ) / 10 ) ; 
                    }            
                    if ( GrandTransporteurs      != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 1, 0] * ( 10 + recherchesAssociees.ReacteurACombustion ) / 10 ) ; 
                    if ( ChasseursLegers         != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 2, 0] * ( 10 + recherchesAssociees.ReacteurACombustion ) / 10 ) ; 
                    if ( ChasseursLourds         != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 3, 0] * ( 10 + recherchesAssociees.ReacteurACombustion ) / 10 ) ; 
                    if ( Croiseurs               != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 4, 0] * ( 10 + 2 * recherchesAssociees.ReacteurAImpulsion ) / 10 ) ; 
                    if ( VaisseauxDeBataille     != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 5, 0] * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ; 
                    if ( VaisseauxDeColonisation != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 6, 0] * ( 10 + 2 * recherchesAssociees.ReacteurAImpulsion ) / 10 ) ; 
                    if ( Recycleurs              != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 7, 0] * ( 10 + recherchesAssociees.ReacteurACombustion ) / 10 ) ; 
                    if ( SondesDEspionnage       != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 8, 0] * ( 10 + recherchesAssociees.ReacteurACombustion ) / 10 ) ; 
                    if ( SatellitesSolaires      != 0 ) v = 0 ;
                    if ( recherchesAssociees.PropulsionHyperespace >= 8 )
                    {
                        if ( Bombardiers             != 0 ) v = Math.Min( v, tableDesCaracteristiques[10, 0] * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ; 
                    }
                    else
                    {
                        if ( Bombardiers             != 0 ) v = Math.Min( v, tableDesCaracteristiques[10, 0] * ( 10 + 2 * recherchesAssociees.ReacteurAImpulsion ) / 10 ) ; 
                    }
                    if ( Destructeurs            != 0 ) v = Math.Min( v, tableDesCaracteristiques[11, 0] * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ; 
                    if ( Battlecruiser           != 0 ) v = Math.Min( v, tableDesCaracteristiques[12, 0] * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ; 
                    if ( EtoilesDeLaMort         != 0 ) v = Math.Min( v, tableDesCaracteristiques[13, 0] * ( 10 + 3 * recherchesAssociees.PropulsionHyperespace ) / 10 ) ; 
                }
                else
                {
                    if ( PetitsTransporteurs     != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 0, 0] ) ; 
                    if ( GrandTransporteurs      != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 1, 0] ) ; 
                    if ( ChasseursLegers         != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 2, 0] ) ; 
                    if ( ChasseursLourds         != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 3, 0] ) ; 
                    if ( Croiseurs               != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 4, 0] ) ; 
                    if ( VaisseauxDeBataille     != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 5, 0] ) ; 
                    if ( VaisseauxDeColonisation != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 6, 0] ) ; 
                    if ( Recycleurs              != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 7, 0] ) ; 
                    if ( SondesDEspionnage       != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 8, 0] ) ; 
                    if ( SatellitesSolaires      != 0 ) v = Math.Min( v, tableDesCaracteristiques[ 9, 0] ) ; 
                    if ( Bombardiers             != 0 ) v = Math.Min( v, tableDesCaracteristiques[10, 0] ) ; 
                    if ( Destructeurs            != 0 ) v = Math.Min( v, tableDesCaracteristiques[11, 0] ) ; 
                    if ( Battlecruiser           != 0 ) v = Math.Min( v, tableDesCaracteristiques[12, 0] ) ; 
                    if ( EtoilesDeLaMort         != 0 ) v = Math.Min( v, tableDesCaracteristiques[13, 0] ) ; 
                }
                return (int)v ;
            }
        }

        public UInt32 CapaciteDeTransport
        {
            get {
                long ct = 0L ;
                if ( recherchesAssociees != null )
                {
                    if ( recherchesAssociees.ReacteurAImpulsion >= 5 )
                    {
                        // On compte 2x plus de soute pour les PT.
                        ct += PetitsTransporteurs     * tableDesCaracteristiques[ 0,2] ;
                    }
                }
                ct += PetitsTransporteurs     * tableDesCaracteristiques[ 0,2] ;
                ct += GrandTransporteurs      * tableDesCaracteristiques[ 1,2] ;
                ct += ChasseursLegers         * tableDesCaracteristiques[ 2,2] ;
                ct += ChasseursLourds         * tableDesCaracteristiques[ 3,2] ;
                ct += Croiseurs               * tableDesCaracteristiques[ 4,2] ;
                ct += VaisseauxDeBataille     * tableDesCaracteristiques[ 5,2] ;
                ct += VaisseauxDeColonisation * tableDesCaracteristiques[ 6,2] ;
                ct += Recycleurs              * tableDesCaracteristiques[ 7,2] ;
              //ct += SondesDEspionnage       * tableDesCaracteristiques[ 8,2] ;
              //ct += SatellitesSolaires      * tableDesCaracteristiques[ 9,2] ;
                ct += Bombardiers             * tableDesCaracteristiques[10,2] ;
                ct += Destructeurs            * tableDesCaracteristiques[11,2] ;
                ct += Battlecruiser           * tableDesCaracteristiques[12,2] ;
                ct += EtoilesDeLaMort         * tableDesCaracteristiques[13,2] ;
                return (uint)ct ;
            }
        }
        public UInt32 CapaciteDeCarburant
        {
            get {
                long ct = CapaciteDeTransport ;
                ct += SondesDEspionnage       * tableDesCaracteristiques[ 8,2] ;
                return (uint)ct ;
            }
        }
    }

    [Serializable]
    public class Defense
    {
        private bool _EstSurUneLune;
        public bool EstSurUneLune
        {
            get { return _EstSurUneLune; }
            set
            {
                //TODO: test de cohérence...
                _EstSurUneLune = value;
            }
        }
        public Defense()
        {
            _EstSurUneLune = false; 
        }
        public Defense( bool EstSurUneLune )
        {
            this._EstSurUneLune = EstSurUneLune;
        }
        public Defense( Defense def )
        {
            this._ArtilleriesAIons = def._ArtilleriesAIons ;
            this._ArtilleriesLaserLegeres = def._ArtilleriesLaserLegeres ;
            this._ArtilleriesLaserLourdes = def._ArtilleriesLaserLourdes ;
            this._CanonsDeGauss = def._CanonsDeGauss ;
            this._EstSurUneLune = def._EstSurUneLune ;
            this._GrandBouclier = def._GrandBouclier ;
            this._LanceursDeMissiles = def._LanceursDeMissiles ;
            this._LanceursDePlasma = def._LanceursDePlasma ;
            this._MissilesDInterception = def._MissilesDInterception ;
            this._MissilesInterplanetaires = def._MissilesInterplanetaires ;
            this._PetitBouclier = def._PetitBouclier ;
        }

        public bool estVide()
        {
            return
                _LanceursDeMissiles == 0
            && _ArtilleriesLaserLegeres == 0
            && _ArtilleriesLaserLourdes == 0
            && _CanonsDeGauss == 0
            && _ArtilleriesAIons == 0
            && _LanceursDePlasma == 0
            && _PetitBouclier == 0
            && _GrandBouclier == 0
            ;
        }
 
        public Ressources ValeurDAchat()
        {
            UInt32 Metal   = 0 ;
            UInt32 Cristal = 0 ;
            UInt32 Deut    = 0 ;
            Metal   += LanceursDeMissiles * 2000 ;
            Metal   += ArtilleriesLaserLegeres * 1500 ;
            Cristal += ArtilleriesLaserLegeres *  500 ;
            Metal   += ArtilleriesLaserLourdes * 6000 ;
            Cristal += ArtilleriesLaserLourdes * 2000 ;
            Metal   += ArtilleriesAIons * 2000 ;
            Cristal += ArtilleriesAIons * 6000 ;
            Metal   += CanonsDeGauss * 20000 ;
            Cristal += CanonsDeGauss * 15000 ;
            Deut    += CanonsDeGauss *  2000 ;
            Metal   += LanceursDePlasma * 50000 ;
            Cristal += LanceursDePlasma * 50000 ;
            Deut    += LanceursDePlasma * 30000 ;
            Metal   += PetitBouclier * 10000 ;
            Cristal += PetitBouclier * 10000 ;
            Metal   += GrandBouclier * 50000 ;
            Cristal += GrandBouclier * 50000 ;
            Metal   += MissilesInterplanetaires * 12500 ;
            Cristal += MissilesInterplanetaires *  2500 ;
            Deut    += MissilesInterplanetaires * 10000 ;
            Metal   += MissilesDInterception * 8000 ;
            Cristal += MissilesDInterception * 2000 ;
            Ressources r = new Ressources() ;
            r.Metal     = Metal   ;
            r.Cristal   = Cristal ;
            r.Deuterium = Deut    ;
            return r ;
        }

        public static Defense operator+ ( Defense d1, Defense d2 )
        {
            Defense d = new Defense(d1) ;
            d.ArtilleriesAIons += d2.ArtilleriesAIons ;
            d.ArtilleriesLaserLegeres += d2.ArtilleriesLaserLegeres ;
            d.ArtilleriesLaserLourdes += d2.ArtilleriesLaserLourdes ;
            d.CanonsDeGauss += d2.CanonsDeGauss ;
            d.GrandBouclier += d2.GrandBouclier ;
            d.LanceursDeMissiles += d2.LanceursDeMissiles ;
            d.LanceursDePlasma += d2.LanceursDePlasma ;
            d.MissilesDInterception += d2.MissilesDInterception ;
            d.MissilesInterplanetaires += d2.MissilesInterplanetaires ;
            d.PetitBouclier += d2.PetitBouclier ;
            return d ;
        }

        public static Defense operator- ( Defense d1, Defense d2 )
        {
            Defense d = new Defense(d1) ;
            if ( d.ArtilleriesAIons > d2.ArtilleriesAIons )
                d.ArtilleriesAIons -= d2.ArtilleriesAIons ;
            else
                d.ArtilleriesAIons = 0 ;
            if ( d.ArtilleriesLaserLegeres > d2.ArtilleriesLaserLegeres )
                d.ArtilleriesLaserLegeres -= d2.ArtilleriesLaserLegeres ;
            else
                d.ArtilleriesLaserLegeres = 0 ;
            if ( d.ArtilleriesLaserLourdes > d2.ArtilleriesLaserLourdes )
                d.ArtilleriesLaserLourdes -= d2.ArtilleriesLaserLourdes ;
            else
                d.ArtilleriesLaserLourdes = 0 ;
            if ( d.CanonsDeGauss > d2.CanonsDeGauss )
                d.CanonsDeGauss -= d2.CanonsDeGauss ;
            else
                d.CanonsDeGauss = 0 ;
            if ( d.LanceursDeMissiles > d2.LanceursDeMissiles )
                d.LanceursDeMissiles -= d2.LanceursDeMissiles ;
            else
                d.LanceursDeMissiles = 0 ;
            if ( d.LanceursDePlasma > d2.LanceursDePlasma )
                d.LanceursDePlasma -= d2.LanceursDePlasma ;
            else
                d.LanceursDePlasma = 0 ;
            if ( d.MissilesDInterception > d2.MissilesDInterception )
                d.MissilesDInterception -= d2.MissilesDInterception ;
            else
                d.MissilesDInterception = 0 ;
            if ( d.MissilesInterplanetaires > d2.MissilesInterplanetaires )
                d.MissilesInterplanetaires -= d2.MissilesInterplanetaires ;
            else
                d.MissilesInterplanetaires = 0 ;
            if ( d.PetitBouclier > d2.PetitBouclier )
                d.PetitBouclier -= d2.PetitBouclier ;
            else
                d.PetitBouclier = 0 ;
            if ( d.GrandBouclier > d2.GrandBouclier )
                d.GrandBouclier -= d2.GrandBouclier ;
            else
                d.GrandBouclier = 0 ;
            return d ;
        }

        public static Defense operator* ( Defense d1, int f )
        {
            Defense d = new Defense(d1) ;
            if ( f > 0 )
            {
                d.ArtilleriesAIons         *= (uint)f ;
                d.ArtilleriesLaserLegeres  *= (uint)f ;
                d.ArtilleriesLaserLourdes  *= (uint)f ;
                d.CanonsDeGauss            *= (uint)f ;
                d.GrandBouclier            *= (uint)f ;
                d.LanceursDeMissiles       *= (uint)f ;
                d.LanceursDePlasma         *= (uint)f ;
                d.MissilesDInterception    *= (uint)f ;
                d.MissilesInterplanetaires *= (uint)f ;
                d.PetitBouclier            *= (uint)f ;
            }
            return d ;
        }


        public Ressources ValeurEnRuines()
        {
            return new Ressources() ;
        }

        
        private UInt32 _LanceursDeMissiles;
        public UInt32 LanceursDeMissiles
        {
            get { return _LanceursDeMissiles; }
            set { _LanceursDeMissiles = value; }
        }
        private UInt32 _ArtilleriesLaserLegeres;
        public UInt32 ArtilleriesLaserLegeres
        {
            get { return _ArtilleriesLaserLegeres; }
            set { _ArtilleriesLaserLegeres = value; }
        }
        private UInt32 _ArtilleriesLaserLourdes;
        public UInt32 ArtilleriesLaserLourdes
        {
            get { return _ArtilleriesLaserLourdes; }
            set { _ArtilleriesLaserLourdes = value; }
        }
        private UInt32 _CanonsDeGauss;
        public UInt32 CanonsDeGauss
        {
            get { return _CanonsDeGauss; }
            set { _CanonsDeGauss = value; }
        }
        private UInt32 _ArtilleriesAIons;
        public UInt32 ArtilleriesAIons
        {
            get { return _ArtilleriesAIons; }
            set { _ArtilleriesAIons = value; }
        }
        private UInt32 _LanceursDePlasma;
        public UInt32 LanceursDePlasma
        {
            get { return _LanceursDePlasma; }
            set { _LanceursDePlasma = value; }
        }
        private UInt32 _PetitBouclier;
        public UInt32 PetitBouclier
        {
            get { return _PetitBouclier ; }
            set { _PetitBouclier = value ; }
        }
        private UInt32 _GrandBouclier;
        public UInt32 GrandBouclier
        {
            get { return _GrandBouclier ; }
            set { _GrandBouclier = value ; }
        }
        private UInt32 _MissilesDInterception;
        public UInt32 MissilesDInterception
        {
            get { if ( _EstSurUneLune ) return 0; else return _MissilesDInterception; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception("Une lune ne peut pas avoir de missiles d'interception");
                _MissilesDInterception = value;
            }
        }
        private UInt32 _MissilesInterplanetaires;
        public UInt32 MissilesInterplanetaires
        {
            get { return _MissilesInterplanetaires; }
            set
            {
                if ( _EstSurUneLune )
                    if ( value != 0 )
                        throw new Exception( "Une lune ne peut pas avoir de missiles interplanetaires" );
                _MissilesInterplanetaires = value;
            }
        }
        public UInt32 Legeres {
            get {
                return ArtilleriesLaserLegeres + LanceursDeMissiles ;
            }
        }
        public UInt32 Moyennes {
            get {
                return ArtilleriesLaserLourdes + ArtilleriesAIons + PetitBouclier ;
            }
        }
        public UInt32 Lourdes {
            get {
                return CanonsDeGauss + LanceursDePlasma + GrandBouclier ;
            }
        }
        public UInt32 Totales
        {
            get
            {
                return Legeres+Moyennes+Lourdes ;
            }
        }
        public UInt32 Nombre
        {
            get
            {
                return Totales ;
            }
        }
    }

    [Serializable]
    public class Technologie
    {
        public Technologie()
        {
        }

        public Technologie( Technologie tech )
        {
            this.Armes = tech.Armes ;
            this.Bouclier = tech.Bouclier ;
            this.Energie = tech.Energie ;
            this.Espionnage = tech.Espionnage ;
            this.Graviton = tech.Graviton ;
            this.Hyperespace = tech.Hyperespace ;
            this.Ions = tech.Ions ;
            this.Laser = tech.Laser ;
            this.Ordinateur = tech.Ordinateur ;
            this.Plasma = tech.Plasma ;
            this.PropulsionHyperespace = tech.PropulsionHyperespace ;
            this.ProtectionDesVaisseauxSpatiaux = tech.ProtectionDesVaisseauxSpatiaux ;
            this.ReacteurACombustion = tech.ReacteurACombustion ;
            this.ReacteurAImpulsion = tech.ReacteurAImpulsion ;
            this.ReseauDeRechercheIntergalactique = tech.ReseauDeRechercheIntergalactique ;
        }

        private UInt32 _Espionnage;
        public UInt32 Espionnage
        {
            get { return _Espionnage; }
            set { _Espionnage = value; }
        }
        private UInt32 _Ordinateur;
        public UInt32 Ordinateur
        {
            get { return _Ordinateur; }
            set { _Ordinateur = value; }
        }
        private UInt32 _Armes;
        public UInt32 Armes
        {
            get { return _Armes; }
            set { _Armes = value; }
        }
        private UInt32 _Bouclier;
        public UInt32 Bouclier
        {
            get { return _Bouclier; }
            set { _Bouclier = value; }
        }
        private UInt32 _ProtectionDesVaisseauxSpatiaux;
        public UInt32 ProtectionDesVaisseauxSpatiaux
        {
            get { return _ProtectionDesVaisseauxSpatiaux; }
            set { _ProtectionDesVaisseauxSpatiaux = value; }
        }
        private UInt32 _Energie;
        public UInt32 Energie
        {
            get { return _Energie; }
            set { _Energie = value; }
        }
        private UInt32 _Hyperespace;
        public UInt32 Hyperespace
        {
            get { return _Hyperespace; }
            set { _Hyperespace = value; }
        }
        private UInt32 _ReacteurACombustion;
        public UInt32 ReacteurACombustion
        {
            get { return _ReacteurACombustion; }
            set { _ReacteurACombustion = value; }
        }
        private UInt32 _ReacteurAImpulsion;
        public UInt32 ReacteurAImpulsion
        {
            get { return _ReacteurAImpulsion; }
            set { _ReacteurAImpulsion = value; }
        }
        private UInt32 _PropulsionHyperespace;
        public UInt32 PropulsionHyperespace
        {
            get { return _PropulsionHyperespace; }
            set { _PropulsionHyperespace = value; }
        }
        private UInt32 _Laser;
        public UInt32 Laser
        {
            get { return _Laser; }
            set { _Laser = value; }
        }
        private UInt32 _Ions;
        public UInt32 Ions
        {
            get { return _Ions; }
            set { _Ions = value; }
        }
        private UInt32 _Plasma;
        public UInt32 Plasma
        {
            get { return _Plasma; }
            set { _Plasma = value; }
        }
        private UInt32 _ReseauDeRechercheIntergalactique;
        public UInt32 ReseauDeRechercheIntergalactique
        {
            get { return _ReseauDeRechercheIntergalactique; }
            set { _ReseauDeRechercheIntergalactique = value; }
        }
        private UInt32 _Graviton;
        public UInt32 Graviton
        {
            get { return _Graviton; }
            set { _Graviton = value; }
        }
    }

    [Serializable]
    public class RapportDEspionnage
    {
        private int _Index ;
        public int Index
        {
            get { return _Index ; }
            set { _Index = value ; }
        }
        private bool _Selected ;
        public bool Selected
        {
            get { return _Selected ; }
            set { _Selected = value ; }
        }
        private Ressources _Ressources;
        public Ressources Ressources
        {
            get { return _Ressources ; }
        }
        private Flotte _FlotteAQuai;
        private bool _FlotteAQuaiEstValide;
        public bool FlotteAQuaiEstValide {get {return _FlotteAQuaiEstValide;}}
        public Flotte FlotteAQuai
        {
            get { return _FlotteAQuai ; }
            set {
                _FlotteAQuai = value ;
                if ( _FlotteAQuai != null )
                {
                    _FlotteAQuai.recherchesAssociees = Recherches ;
                }
            }
        }
        private Defense _Defenses;
        private bool _DefensesEstValide;
        public bool DefensesEstValide { get { return _DefensesEstValide; } }
        public Defense Defenses
        {
            get { return _Defenses ; }
            set { _Defenses = value ; }
        }
        private Batiments _Batiments;
        private bool _BatimentsEstValide;
        public bool BatimentsEstValide { get { return _BatimentsEstValide; } }
        public Batiments Batiments
        {
            get { return _Batiments; }
            set { _Batiments = value ; }
        }
        private Technologie _Recherches;
        private bool _RecherchesEstValide;
        public bool RecherchesEstValide { get { return _RecherchesEstValide; } }
        public Technologie Recherches
        {
            get { return _Recherches; }
            set {
                _Recherches = value ;
                if ( _FlotteAQuai != null )
                {
                    _FlotteAQuai.recherchesAssociees = value ;
                }
            }
        }

        private string _NomDeLaPlanete;
        public string NomDeLaPlanete
        {
            get { return _NomDeLaPlanete; }
            set { _NomDeLaPlanete = value; }
        }
        private Coordonnees _Coordonnees;
        public Coordonnees Coordonnees
        {
            get { return _Coordonnees; }
            set { _Coordonnees = value; }
        }
        private bool _EstUneLune;
        public bool EstUneLune
        {
            get { return _EstUneLune; }
            set
            {
                if ( value != _EstUneLune )
                {
                    Defenses.EstSurUneLune = value ;
                    Batiments.EstSurUneLune = value ;
                }
                _EstUneLune = value;
            }
        }
        private uint _Cases;
        public uint Cases
        {
            get { return _Cases; }
            set { _Cases = value; }
        }
        private DateTime _DateEtHeure;
        public DateTime DateEtHeure
        {
            get { return _DateEtHeure; }
            set { _DateEtHeure = value; }
        }

        private string _Commentaire;
        public string Commentaire
        {
            get {
                if ( _Commentaire == null )
                {
                    _Commentaire = "" ;
                }
                return _Commentaire ;
            }
            set {
                _Commentaire = value ;
            }
        }

        private string _Contributeur;
        public string Contributeur
        {
            get {
                if ( _Contributeur == null )
                {
                    _Contributeur = "" ;
                }
                return _Contributeur ;
            }
            set {
                _Contributeur = value ;
            }
        }

        private void init()
        {
            _Selected = false ;

            _EstUneLune = false;
            _Ressources  = new Ressources();
            FlotteAQuai = new Flotte();
            Batiments   = new Batiments();
            Defenses    = new Defense();
            Recherches  = new Technologie();

            _NomDeLaPlanete = "Planete inconnue";
            _Coordonnees = new Coordonnees();
            _DateEtHeure = DateTime.Now;

            _Commentaire = "" ;
            _Contributeur = "" ;
            _Cases = 0;
        }

        public RapportDEspionnage()
        {
            init() ;
        }

        String Cherche( string rapport, string regex ) 
        {
            Regex r = new Regex( regex, RegexOptions.IgnoreCase );
            Match m = r.Match( rapport );
            if ( m.Success )
            {
                return m.Groups[1].Value ;
            }
            return "" ;
        }

        UInt32 ChercheNombreDe( string rapport, string item ) 
        {
            Regex r = new Regex( item + @"\s*(\d+)", RegexOptions.IgnoreCase );
            Match m = r.Match( rapport );
            if ( m.Success )
            {
                return System.Convert.ToUInt32(m.Groups[1].Value) ;
            }
            return 0 ;
        }

        public override bool Equals( Object r )
        {
            RapportDEspionnage Rapport = (r as RapportDEspionnage) ;
            if ( r == null ) return false ;
            return 
                true
//             && this.Batiments == Rapport.Batiments 
//             && this.Cases == Rapport.Cases
             && this.Coordonnees.Equals( Rapport.Coordonnees )
             && this.DateEtHeure.Equals( Rapport.DateEtHeure )
//             && this.Defenses == Rapport.Defenses
//             && this.EstUneLune == Rapport.EstUneLune
//             && this.FlotteAQuai == Rapport.FlotteAQuai
//             && this.NomDeLaPlanete == Rapport.NomDeLaPlanete
//             && this.Recherches == Rapport.Recherches
//             && this.Ressources == Rapport.Ressources
                ;
        }
        public override int GetHashCode()
        {
            return base.GetHashCode();
        }
        
        public RapportDEspionnage( RapportDEspionnage rapport )
        {
            this._Batiments = new Batiments( rapport._Batiments ) ;
            this._BatimentsEstValide = rapport._BatimentsEstValide ;
            this._Cases = rapport._Cases ;
            this._Coordonnees = new Coordonnees( rapport._Coordonnees ) ;
            this._DateEtHeure = rapport._DateEtHeure ;
            this._Defenses = new Defense( rapport._Defenses ) ;
            this._DefensesEstValide = rapport._DefensesEstValide ;
            this._EstUneLune = rapport._EstUneLune ;
            this._FlotteAQuai = new Flotte( rapport._FlotteAQuai ) ;
            this._FlotteAQuaiEstValide = rapport._FlotteAQuaiEstValide ;
            this._Index = rapport._Index ;
            this._NomDeLaPlanete = rapport._NomDeLaPlanete ;
            this.Recherches = new Technologie( rapport._Recherches ) ;
            this._RecherchesEstValide = rapport._RecherchesEstValide ;
            this._Ressources = new Ressources( rapport._Ressources ) ;
            this._Selected = rapport._Selected ;
            this._Commentaire = rapport._Commentaire ;
            this._Contributeur = rapport._Contributeur ;
        }
        
        public RapportDEspionnage( string rapportBrut )
        {
            String rapport = Utils.EnlevePoints(rapportBrut) ;
            init() ;
            try
            {
                NomDeLaPlanete = Cherche( rapport, @"sur ([a-zA-Zéèàêë0-9\. _-]+)(?: \(Lune\))? \[\d+:\d+:\d+\] le" );

                Coordonnees = Cherche( rapport, @"\[(\d+:\d+:\d+)\] le" );

                DateEtHeure = new DateTime(
                    DateTime.Now.Year ,
                    System.Convert.ToInt32( Cherche(rapport, @"\] le (\d+)-\d+ \d+:\d+:\d+") ) ,
                    System.Convert.ToInt32( Cherche(rapport, @"\] le \d+-(\d+) \d+:\d+:\d+") ) ,
                    System.Convert.ToInt32( Cherche(rapport, @"\] le \d+-\d+ (\d+):\d+:\d+") ) ,
                    System.Convert.ToInt32( Cherche(rapport, @"\] le \d+-\d+ \d+:(\d+):\d+") ) ,
                    System.Convert.ToInt32( Cherche(rapport, @"\] le \d+-\d+ \d+:\d+:(\d+)") ) ,
                    0 ) ;
                if ( DateEtHeure.Ticks > DateTime.Now.Ticks )
                {
                    DateEtHeure = DateEtHeure.AddYears( -1 ) ;
                }

                Ressources.Metal     = ChercheNombreDe( rapport, "Métal:" );
                Ressources.Cristal   = ChercheNombreDe( rapport, "Cristal:" );
                Ressources.Deuterium = ChercheNombreDe( rapport, "Deutérium:" );
                Ressources.Energie   = ChercheNombreDe( rapport, "Energie:" );

                EstUneLune = NomDeLaPlanete.ToLower() == "lune" ;
                if ( rapport.Contains("(Lune)") ) EstUneLune = true ;
                if ( rapport.Contains("Silo de missiles") ) EstUneLune = false ;
                if ( rapport.Contains("Usine de nanites") ) EstUneLune = false ;
                if ( rapport.Contains("Mine de cristal") ) EstUneLune = false ;
                if ( rapport.Contains("Mine de métal") ) EstUneLune = false ;
                if ( rapport.Contains("Synthétiseur de deutérium") ) EstUneLune = false ;
                if ( rapport.Contains("Centrale électrique de fusion") ) EstUneLune = false ;
                if ( rapport.Contains("Centrale électrique solaire") ) EstUneLune = false ;
                if ( rapport.Contains("Terraformeur") ) EstUneLune = false ;
                if ( rapport.Contains("Base lunaire") ) EstUneLune = true ;
                if ( rapport.Contains("Porte de saut spatial") ) EstUneLune = true ;
                if ( rapport.Contains("Phalange de capteur") ) EstUneLune = true ;
                if ( EstUneLune )
                {
                    Coordonnees.Type = TypeDeCoordonnees.Lune ;
                }
                
               _DefensesEstValide = rapport.Contains( "Défense" );
                Defenses.ArtilleriesAIons         = ChercheNombreDe( rapport, "Artillerie à ions" );
                Defenses.ArtilleriesLaserLegeres  = ChercheNombreDe( rapport, "Artillerie laser légère" );
                Defenses.ArtilleriesLaserLourdes  = ChercheNombreDe( rapport, "Artillerie laser lourde" );
                Defenses.CanonsDeGauss            = ChercheNombreDe( rapport, "Canon de Gauss" );
                Defenses.GrandBouclier            = ChercheNombreDe( rapport, "Grand bouclier" );
                Defenses.LanceursDeMissiles       = ChercheNombreDe( rapport, "Lanceur de missiles" );
                Defenses.LanceursDePlasma         = ChercheNombreDe( rapport, "Lanceur de plasma" );
                Defenses.MissilesDInterception    = ChercheNombreDe( rapport, "Missile Interception" );
                Defenses.MissilesInterplanetaires = ChercheNombreDe( rapport, "Missile Interplanétaire" );
                Defenses.PetitBouclier            = ChercheNombreDe( rapport, "Petit bouclier" );

                _FlotteAQuaiEstValide = rapport.Contains( "Flotte" );
                FlotteAQuai.Bombardiers             = ChercheNombreDe( rapport, "Bombardier" );
                FlotteAQuai.ChasseursLegers         = ChercheNombreDe( rapport, "Chasseur léger" );
                FlotteAQuai.ChasseursLourds         = ChercheNombreDe( rapport, "Chasseur lourd" ); // A vérifier
                FlotteAQuai.Croiseurs               = ChercheNombreDe( rapport, "Croiseur" );
                FlotteAQuai.Destructeurs            = ChercheNombreDe( rapport, "Destructeur" ); // A vérifier
                FlotteAQuai.Battlecruiser           = ChercheNombreDe( rapport, "Traqueur" ); // A vérifier
                FlotteAQuai.EtoilesDeLaMort         = ChercheNombreDe( rapport, "toile de la mort" ); // Un E en trop qui m'aura couté 6 bouboulles... :/
                FlotteAQuai.GrandTransporteurs      = ChercheNombreDe( rapport, "Grand transporteur" );
                FlotteAQuai.PetitsTransporteurs     = ChercheNombreDe( rapport, "Petit transporteur" ); // A vérifier
                FlotteAQuai.Recycleurs              = ChercheNombreDe( rapport, "Recycleur" );
                FlotteAQuai.SatellitesSolaires      = ChercheNombreDe( rapport, "Satellite solaire" );
                FlotteAQuai.SondesDEspionnage       = ChercheNombreDe( rapport, "Sonde espionnage" );
                FlotteAQuai.VaisseauxDeBataille     = ChercheNombreDe( rapport, "Vaisseau de bataille" );
                FlotteAQuai.VaisseauxDeColonisation = ChercheNombreDe( rapport, "Vaisseau de colonisation" ); // A vérifier

                _BatimentsEstValide = rapport.Contains( "Bâtiments" );
                Batiments.BaseLunaire             = ChercheNombreDe( rapport, "Base lunaire" );
                Batiments.CentraleFusion          = ChercheNombreDe( rapport, "Centrale électrique de fusion" );
                Batiments.CentraleSolaire         = ChercheNombreDe( rapport, "Centrale électrique solaire" );
                Batiments.ChantierSpatial         = ChercheNombreDe( rapport, "Chantier spatial" );
                Batiments.HangarDeCristal         = ChercheNombreDe( rapport, "Hangar de cristal" );
                Batiments.HangarDeMetal           = ChercheNombreDe( rapport, "Hangar de métal" );
                Batiments.LaboratoireDeRecherche  = ChercheNombreDe( rapport, "Laboratoire de recherche" );
                Batiments.MineDeCristal           = ChercheNombreDe( rapport, "Mine de cristal" );
                Batiments.MineDeMetal             = ChercheNombreDe( rapport, "Mine de métal" );
                Batiments.PhalangeDeCapteur       = ChercheNombreDe( rapport, "Phalange de capteur" );
                Batiments.PorteDeSautSpatial      = ChercheNombreDe( rapport, "Porte de saut spatial" );
                Batiments.ReservoirDeDeuterium    = ChercheNombreDe( rapport, "Réservoir de deutérium" );
                Batiments.SiloDeMissiles          = ChercheNombreDe( rapport, "Silo de missiles" );
                Batiments.SynthetiseurDeDeuterium = ChercheNombreDe( rapport, "Synthétiseur de deutérium" );
                Batiments.Terraformeur            = ChercheNombreDe( rapport, "Terraformeur" );
                Batiments.UsineDeNanites          = ChercheNombreDe( rapport, "Usine de nanites" );
                Batiments.UsineDeRobots           = ChercheNombreDe( rapport, "Usine de robots" );

                _RecherchesEstValide = rapport.Contains( "Recherche" );
                Recherches.Armes                            = ChercheNombreDe( rapport, "Technologie Armes" );
                Recherches.Bouclier                         = ChercheNombreDe( rapport, "Technologie Bouclier" );
                Recherches.Energie                          = ChercheNombreDe( rapport, "Technologie Energie" );
                Recherches.Espionnage                       = ChercheNombreDe( rapport, "Technologie Espionnage" );
                Recherches.Graviton                         = ChercheNombreDe( rapport, "Technologie Graviton" );
                Recherches.Hyperespace                      = ChercheNombreDe( rapport, "Technologie Hyperespace" );
                Recherches.Ions                             = ChercheNombreDe( rapport, "Technologie Ions" );
                Recherches.Laser                            = ChercheNombreDe( rapport, "Technologie Laser" );
                Recherches.Ordinateur                       = ChercheNombreDe( rapport, "Technologie Ordinateur" );
                Recherches.Plasma                           = ChercheNombreDe( rapport, "Technologie Plasma" );
                Recherches.PropulsionHyperespace            = ChercheNombreDe( rapport, "Propulsion hyperespace" );
                Recherches.ProtectionDesVaisseauxSpatiaux   = ChercheNombreDe( rapport, "Protection des vaisseaux spatiaux" );
                Recherches.ReacteurACombustion              = ChercheNombreDe( rapport, "Réacteur à combustion" );
                Recherches.ReacteurAImpulsion               = ChercheNombreDe( rapport, "Réacteur à impulsion" );
                Recherches.ReseauDeRechercheIntergalactique = ChercheNombreDe( rapport, "Réseau de recherche intergalactique" );

            }
            catch ( Exception /*e*/ )
            {
                _DefensesEstValide = false ;
                _BatimentsEstValide = false ;
                _RecherchesEstValide = false ;
                _FlotteAQuaiEstValide = false ;
            }
            FlotteAQuai.CoordonneesDeDepart = Coordonnees ;
        }
        
        public bool estUnPigeon()
        {
            return _DefensesEstValide && _FlotteAQuaiEstValide && Defenses.estVide() && FlotteAQuai.estVide() ;
        }
        /*
        public String TexteDuRapport
        {
            get
            {
                String Text = "" ;
                Text +=
"Matières premières sur " + this.NomDeLaPlanete + " ["+this.Coordonnees+"] le " + this.DateEtHeure.ToString("MM-dd hh:mm:ss") + "\r\n"+
"Métal:\t\t" + this.Ressources.Metal + "\t\tCristal:\t" + this.Ressources.Cristal + "\r\n" +
"Deutérium:\t" + this.Ressources.Deuterium + "\t\tEnergie:\t" + this.Ressources.Energie + "\r\n" +
"\r\n" ;
                if ( this.FlotteAQuaiEstValide )
                {
                    Text +=
"Flotte\r\n" +
"Petit transporteur \t\t" + this.FlotteAQuai.PetitsTransporteurs + "\t\t" +
"Grand transporteur \t\t" + this.FlotteAQuai.GrandTransporteurs + "\t\t" + "\r\n" +
"Chasseur léger \t\t" + this.FlotteAQuai.ChasseursLegers + "\t\t" +
"Chasseur lourd \t\t" + this.FlotteAQuai.ChasseursLourds + "\t\t" + "\r\n" +
"Croiseur \t\t\t" + this.FlotteAQuai.Croiseurs + "\t\t" +  
"Vaisseau de bataille \t" + this.FlotteAQuai.VaisseauxDeBataille + "\t\t" + "\r\n" + 
"Vaisseau de colonisation \t" + this.FlotteAQuai.VaisseauxDeColonisation + "\t\t" +
"Sonde espionnage \t\t" + this.FlotteAQuai.SondesDEspionnage + "\t\t" + "\r\n" +
"Recycleur \t\t" + this.FlotteAQuai.Recycleurs + "\t\t" +
"Satellite solaire \t\t" + this.FlotteAQuai.SatellitesSolaires + "\t\t" + "\r\n" +
"Bombardier \t\t" + this.FlotteAQuai.Bombardiers + "\t\t" +
"Destructeur \t\t" + this.FlotteAQuai.Destructeurs + "\t\t" + "\r\n" +
"Traqueur \t\t\t" + this.FlotteAQuai.Battlecruiser + "\t\t" +
"Etoile de la mort \t\t" + this.FlotteAQuai.EtoilesDeLaMort + "\t\t" +
"\r\n\r\n";
                }
                if ( this.DefensesEstValide )
                {
                    Text +=
"Défense\r\n" +
"Lanceur de missiles \t" + this.Defenses.LanceursDeMissiles + "\t\t" +
"Artillerie laser légère \t" + this.Defenses.ArtilleriesLaserLegeres + "\t\t" + "\r\n" +
"Artillerie laser lourde \t" + this.Defenses.ArtilleriesLaserLourdes + "\t\t" +
"Artillerie à ions \t\t" + this.Defenses.ArtilleriesAIons + "\t\t" + "\r\n" +
"Canon de Gauss \t\t" + this.Defenses.CanonsDeGauss + "\t\t" +
"Lanceur de plasma \t\t" + this.Defenses.LanceursDePlasma + "\t\t" + "\r\n" +
"Petit bouclier \t\t" + this.Defenses.PetitBouclier + "\t\t" +
"Grand bouclier \t\t" + this.Defenses.GrandBouclier + "\t\t" + "\r\n" +
"Missile Interception \t\t" + this.Defenses.MissilesDInterception + "\t\t" +
"Missile Interplanétaire \t" + this.Defenses.MissilesInterplanetaires + "\t\t" +
"\r\n\r\n";
                }
                if ( this.BatimentsEstValide )
                {
                    if ( ! this.EstUneLune )
                    {
                        Text +=
"Bâtiments\r\n" +
"Mine de métal\t\t" + this.Batiments.MineDeMetal + "\t\t" +
"Mine de cristal\t\t" + this.Batiments.MineDeCristal + "\t\t" + "\r\n" +
"Synthétiseur de deutérium\t" + this.Batiments.SynthetiseurDeDeuterium + "\t\t" +
"Centrale électrique solaire\t" + this.Batiments.CentraleSolaire + "\t\t" + "\r\n" +
"Centrale électrique de fusion\t" + this.Batiments.CentraleFusion + "\t\t" +
"Usine de robots\t\t" + this.Batiments.UsineDeRobots + "\t\t" + "\r\n" +
"Usine de nanites\t\t" + this.Batiments.UsineDeNanites + "\t\t" +
"Chantier spatial\t\t" + this.Batiments.ChantierSpatial + "\t\t" + "\r\n" +
"Hangar de métal\t\t" + this.Batiments.HangarDeMetal + "\t\t" +
"Hangar de cristal\t\t" + this.Batiments.HangarDeCristal + "\t\t" + "\r\n" +
"Réservoir de deutérium\t" + this.Batiments.ReservoirDeDeuterium + "\t\t" +
"Laboratoire de recherche\t" + this.Batiments.LaboratoireDeRecherche + "\t\t" + "\r\n" +
"Terraformeur\t\t" + this.Batiments.Terraformeur + "\t\t" +
"\r\n\r\n" ;
                    }
                    else // this.EstUneLune
                    {
                        Text +=
"Bâtiments\r\n" +
"Usine de robots\t\t" + this.Batiments.UsineDeRobots + "\t\t" +
"Chantier spatial\t\t" + this.Batiments.ChantierSpatial + "\t\t" + "\r\n" +
"Hangar de métal\t\t" + this.Batiments.HangarDeMetal + "\t\t" +
"Hangar de cristal\t\t" + this.Batiments.HangarDeCristal + "\t\t" + "\r\n" +
"Réservoir de deutérium\t" + this.Batiments.ReservoirDeDeuterium + "\t\t" +
"Laboratoire de recherche\t" + this.Batiments.LaboratoireDeRecherche + "\t\t" + "\r\n" +
"Base lunaire\t\t" + this.Batiments.BaseLunaire + "\t\t" +
"Phalange de capteur\t" + this.Batiments.PhalangeDeCapteur + "\t\t" + "\r\n" +
"Porte de saut spatial\t" + this.Batiments.PorteDeSautSpatial + "\t\t" +
"\r\n\r\n" ;
                    }
                }
                if ( this.RecherchesEstValide )
                {
                    Text +=
"Recherche\r\n" +
"Technologie Espionnage\t" + this.Recherches.Espionnage + "\t\t" +
"Technologie Ordinateur\t" + this.Recherches.Ordinateur + "\t\t" + "\r\n" +
"Technologie Armes\t\t" + this.Recherches.Armes + "\t\t" +
"Technologie Bouclier\t" + this.Recherches.Bouclier + "\t\t" + "\r\n" +
"Protection des vaisseaux\t" + this.Recherches.ProtectionDesVaisseauxSpatiaux + "\t\t" +
"Technologie Energie\t" + this.Recherches.Energie + "\t\t" + "\r\n" +
"Technologie Hyperespace\t" + this.Recherches.Hyperespace + "\t\t" +
"Réacteur à combustion\t" + this.Recherches.ReacteurACombustion + "\t\t" + "\r\n" +
"Réacteur à impulsion\t" + this.Recherches.ReacteurAImpulsion + "\t\t" +
"Propulsion hyperespace\t" + this.Recherches.PropulsionHyperespace + "\t\t" + "\r\n" +
"Technologie Laser\t\t" + this.Recherches.Laser + "\t\t" +
"Technologie Ions\t\t" + this.Recherches.Ions + "\t\t" + "\r\n" +
"Technologie Plasma\t" + this.Recherches.Plasma + "\t\t" +
"Réseau de recherche\t" + this.Recherches.ReseauDeRechercheIntergalactique + "\t\t" +
"\r\n\r\n";
                }
                return Text ;
            }
        }
        */

        private int colonne ;
        private void afficheInfo( StringBuilder sb, String intitule, uint valeur )
        {
            if ( valeur != 0 )
            {
                if ( colonne == 1 )
                {
                    sb.Append( "\t" ) ;
                }
                sb.Append( intitule ) ;
                sb.Append( "\t" ) ;
                sb.Append( Utils.affEntierAvecPoints(valeur) ) ;
                if ( colonne == 0 )
                {
                    colonne = 1 ;
                }
                else
                {
                    colonne = 0 ;
                    sb.Append( "\r\n" ) ;
                }
            }
        }
        public String Texte
        {
            get {
                StringBuilder sb = new StringBuilder() ;
                sb.Append(
"Matières premières sur " + this.NomDeLaPlanete + " ["+this.Coordonnees+"] le " + this.DateEtHeure.ToString("MM-dd hh:mm:ss") + "\r\n"+
"Métal:\t" + Utils.affEntierAvecPoints(this.Ressources.Metal) +
" \tCristal:\t" + Utils.affEntierAvecPoints(this.Ressources.Cristal) + "\r\n" +
"Deutérium:\t" + Utils.affEntierAvecPoints(this.Ressources.Deuterium) +
" \tEnergie:\t" + Utils.affEntierAvecPoints(this.Ressources.Energie) + "\r\n" ) ;
                colonne = 0 ;
                if ( this.FlotteAQuaiEstValide )
                {
                    sb.Append("Flotte\r\n") ;
afficheInfo( sb, "Petit transporteur", this.FlotteAQuai.PetitsTransporteurs ) ;
afficheInfo( sb, "Grand transporteur", this.FlotteAQuai.GrandTransporteurs ) ;
afficheInfo( sb, "Chasseur léger", this.FlotteAQuai.ChasseursLegers ) ;
afficheInfo( sb, "Chasseur lourd", this.FlotteAQuai.ChasseursLourds ) ;
afficheInfo( sb, "Croiseur", this.FlotteAQuai.Croiseurs ) ;
afficheInfo( sb, "Vaisseau de bataille", this.FlotteAQuai.VaisseauxDeBataille ) ;
afficheInfo( sb, "Vaisseau de colonisation", this.FlotteAQuai.VaisseauxDeColonisation ) ;
afficheInfo( sb, "Sonde espionnage", this.FlotteAQuai.SondesDEspionnage ) ;
afficheInfo( sb, "Recycleur", this.FlotteAQuai.Recycleurs ) ;
afficheInfo( sb, "Satellite solaire", this.FlotteAQuai.SatellitesSolaires ) ;
afficheInfo( sb, "Bombardier", this.FlotteAQuai.Bombardiers ) ;
afficheInfo( sb, "Destructeur", this.FlotteAQuai.Destructeurs ) ;
afficheInfo( sb, "Traqueur", this.FlotteAQuai.Battlecruiser ) ;
afficheInfo( sb, "Etoile de la mort", this.FlotteAQuai.EtoilesDeLaMort ) ;
                }
                if ( colonne == 1 ) sb.Append("\r\n") ;
                colonne = 0 ;
                if ( this.DefensesEstValide )
                {
                    sb.Append("Défense\r\n") ;
afficheInfo( sb, "Lanceur de missiles", this.Defenses.LanceursDeMissiles ) ;
afficheInfo( sb, "Artillerie laser légère", this.Defenses.ArtilleriesLaserLegeres ) ;
afficheInfo( sb, "Artillerie laser lourde", this.Defenses.ArtilleriesLaserLourdes ) ;
afficheInfo( sb, "Canon de Gauss", this.Defenses.CanonsDeGauss ) ;
afficheInfo( sb, "Artillerie à ions", this.Defenses.ArtilleriesAIons ) ;
afficheInfo( sb, "Lanceur de plasma", this.Defenses.LanceursDePlasma ) ;
afficheInfo( sb, "Petit bouclier", this.Defenses.PetitBouclier ) ;
afficheInfo( sb, "Grand bouclier", this.Defenses.GrandBouclier ) ;
afficheInfo( sb, "Missile Interception", this.Defenses.MissilesDInterception ) ;
afficheInfo( sb, "Missile Interplanétaire", this.Defenses.MissilesInterplanetaires ) ;
                }
                if ( colonne == 1 ) sb.Append("\r\n") ;
                colonne = 0 ;
                if ( this.BatimentsEstValide )
                {
                    if ( ! this.EstUneLune )
                    {
                        sb.Append("Bâtiments\r\n") ;
afficheInfo( sb, "Mine de métal", this.Batiments.MineDeMetal ) ;
afficheInfo( sb, "Mine de cristal", this.Batiments.MineDeCristal ) ;
afficheInfo( sb, "Synthétiseur de deutérium", this.Batiments.SynthetiseurDeDeuterium ) ;
afficheInfo( sb, "Centrale électrique solaire", this.Batiments.CentraleSolaire ) ;
afficheInfo( sb, "Centrale électrique de fusion", this.Batiments.CentraleFusion ) ;
afficheInfo( sb, "Usine de robots", this.Batiments.UsineDeRobots ) ;
afficheInfo( sb, "Usine de nanites", this.Batiments.UsineDeNanites ) ;
afficheInfo( sb, "Chantier spatial", this.Batiments.ChantierSpatial ) ;
afficheInfo( sb, "Hangar de métal", this.Batiments.HangarDeMetal ) ;
afficheInfo( sb, "Hangar de cristal", this.Batiments.HangarDeCristal ) ;
afficheInfo( sb, "Réservoir de deutérium", this.Batiments.ReservoirDeDeuterium ) ;
afficheInfo( sb, "Laboratoire de recherche", this.Batiments.LaboratoireDeRecherche ) ;
afficheInfo( sb, "Silo de missiles", this.Batiments.SiloDeMissiles ) ;
afficheInfo( sb, "Terraformeur", this.Batiments.Terraformeur ) ;
                    }
                    else // this.EstUneLune
                    {
                        sb.Append("Bâtiments\r\n") ;
afficheInfo( sb, "Usine de robots", this.Batiments.UsineDeRobots ) ;
afficheInfo( sb, "Chantier spatial", this.Batiments.ChantierSpatial ) ;
afficheInfo( sb, "Hangar de métal", this.Batiments.HangarDeMetal ) ;
afficheInfo( sb, "Hangar de cristal", this.Batiments.HangarDeCristal ) ;
afficheInfo( sb, "Réservoir de deutérium", this.Batiments.ReservoirDeDeuterium ) ;
afficheInfo( sb, "Base lunaire", this.Batiments.BaseLunaire ) ;
afficheInfo( sb, "Phalange de capteur", this.Batiments.PhalangeDeCapteur ) ;
afficheInfo( sb, "Porte de saut spatial", this.Batiments.PorteDeSautSpatial ) ;
                    }
                }
                if ( colonne == 1 ) sb.Append("\r\n") ;
                colonne = 0 ;
                if ( this.RecherchesEstValide )
                {
                    sb.Append("Recherche\r\n") ;
afficheInfo( sb, "Technologie Espionnage", this.Recherches.Espionnage ) ;
afficheInfo( sb, "Technologie Ordinateur", this.Recherches.Ordinateur ) ;
afficheInfo( sb, "Technologie Armes", this.Recherches.Armes ) ;
afficheInfo( sb, "Technologie Bouclier", this.Recherches.Bouclier ) ;
afficheInfo( sb, "Technologie Protection des vaisseaux spatiaux", this.Recherches.ProtectionDesVaisseauxSpatiaux ) ;
afficheInfo( sb, "Technologie Energie", this.Recherches.Energie ) ;
afficheInfo( sb, "Technologie Hyperespace", this.Recherches.Hyperespace ) ;
afficheInfo( sb, "Réacteur à combustion", this.Recherches.ReacteurACombustion ) ;
afficheInfo( sb, "Réacteur à impulsion", this.Recherches.ReacteurAImpulsion ) ;
afficheInfo( sb, "Propulsion hyperespace", this.Recherches.PropulsionHyperespace ) ;
afficheInfo( sb, "Technologie Laser", this.Recherches.Laser ) ;
afficheInfo( sb, "Technologie Ions", this.Recherches.Ions ) ;
afficheInfo( sb, "Technologie Plasma", this.Recherches.Plasma ) ;
afficheInfo( sb, "Réseau de recherche intergalactique", this.Recherches.ReseauDeRechercheIntergalactique ) ;
afficheInfo( sb, "Technologie Graviton", this.Recherches.Graviton ) ;
                }
                return sb.ToString() ;
            }
        }
    
    }

    public enum StatusJoueur
    {
        NonRenseigne = 0 ,
        Normal       = 1 ,
        Debutant     = 2 ,
        Inactif      = 3 ,
        InactifLong  = 4 ,
        Vacances     = 5 ,
        Bloque       = 6
    }
    public delegate bool FonctionDeParcoursPlanetes( Planete p ) ;
    public delegate bool FonctionDeParcoursSystemes( Systeme s ) ;
    [Serializable]
    public class Planete
    {
        [NonSerialized] private Coordonnees _coordonnees ;
        public Coordonnees coordonnees
        {
            get { return _coordonnees ; }
            set { _coordonnees = value ; }
        }
        private string _Nom ;
        public string Nom
        {
            get { return _Nom ; }
            set { _Nom = value ; }
        }
        private string _Joueur ;
        public string Joueur
        {
            get { return _Joueur ; }
            set { _Joueur = value ; }
        }
        private string _Alliance ;
        public string Alliance
        {
            get { return _Alliance ; }
            set { _Alliance = value ; }
        }
        private bool _AUneLune ;
        public bool AUneLune
        {
            get { return _AUneLune ; }
            set { _AUneLune = value ; }
        }
        private StatusJoueur _Status ;
        public StatusJoueur Status
        {
            get { return _Status ; }
            set { _Status = value ; }
        }
        private DateTime _DateEtHeureDeLecture ;
        public DateTime DateEtHeureDeLecture
        {
            get { return _DateEtHeureDeLecture ; }
            set { _DateEtHeureDeLecture = value ; }
        }
        public Planete()
        {
            _Nom = "Planète inconnue" ;
            _Joueur = "Joueur inconnu" ;
            _Alliance = "Alliance inconnue" ;
            _Status = StatusJoueur.Normal ;
            _DateEtHeureDeLecture = DateTime.MinValue ;
            _coordonnees = new Coordonnees() ;
            _AUneLune = false ;
        }
    }
    [Serializable]
    public class Systeme
    {
        private int _galaxie ;
        public int galaxie
        {
            get {
                return _galaxie ;
            }
            set {
                _galaxie = value ;
            }
        }
        private int _systeme ;
        public int systeme
        {
            get {
                return _systeme ;
            }
            set {
                _systeme = value ;
            }
        }
        private Planete[] _Planetes ;
        public Planete this[ int p ]
        {
            get {
                if ( p < 1 || p >  Valeurs.maxPlanete ) throw new Exception("Un numéro de planète est compris entre 1 et 15.") ;
                if ( _Planetes[p] == null )
                {
                    _Planetes[p] = new Planete() ;
                }
                if ( _Planetes[p].coordonnees == null ) _Planetes[p].coordonnees = new Coordonnees() ;
                _Planetes[p].coordonnees.Galaxie = (ushort)galaxie ;
                _Planetes[p].coordonnees.Systeme = (ushort)systeme ;
                _Planetes[p].coordonnees.Planete = (ushort)p ;
                return _Planetes[p] ;
            }
            set {
                if ( p < 1 || p >  15 ) throw new Exception("Un numéro de planète est compris entre 1 et 15.") ;
                if ( value == null )
                {
                    _Planetes[p] = new Planete() ;
                    if ( _Planetes[p].coordonnees == null ) _Planetes[p].coordonnees = new Coordonnees() ;
                    _Planetes[p].coordonnees.Galaxie = (ushort)galaxie ;
                    _Planetes[p].coordonnees.Systeme = (ushort)systeme ;
                    _Planetes[p].coordonnees.Planete = (ushort)p ;
                }
                else
                {
                    _Planetes[p] = value ;
                    if ( _Planetes[p].coordonnees == null ) _Planetes[p].coordonnees = new Coordonnees() ;
                    _Planetes[p].coordonnees.Galaxie = (ushort)galaxie ;
                    _Planetes[p].coordonnees.Systeme = (ushort)systeme ;
                    _Planetes[p].coordonnees.Planete = (ushort)p ;
                }
            }
        }
        public Systeme()
        {
            _Planetes = new Planete[Valeurs.maxPlanete+1] ;
        }
        public bool PlaneteNonNulle( int p )
        {
            if ( p < 1 || p >  Valeurs.maxPlanete ) throw new Exception("Un numéro de planète est compris entre 1 et "+Valeurs.maxPlanete+".") ;
            return _Planetes[p] != null ;
        }
        public int NombreDePlanetes()
        {
            int compte = 0 ;
            for ( int i = 1 ; i <= Valeurs.maxPlanete ; ++i )
            {
                if ( _Planetes[i] != null )
                {
                    if ( _Planetes[i].Nom != "" )
                    {
                        ++compte ;
                    }
                }
            }
            return compte ;
        }
        public int NombreDeLunes()
        {
            int compte = 0 ;
            for ( int i = 1 ; i <= Valeurs.maxPlanete ; ++i )
            {
                if ( _Planetes[i] != null )
                {
                    if ( _Planetes[i].AUneLune )
                    {
                        ++compte ;
                    }
                }
            }
            return compte ;
        }
        public DateTime DateEtHeureDuRapportLePlusRecent()
        {
            DateTime dt = DateTime.MinValue ;
            for ( int i = 1 ; i <= Valeurs.maxPlanete ; ++i )
            {
                if ( _Planetes[i] != null )
                {
                    if ( _Planetes[i].DateEtHeureDeLecture > dt )
                    {
                        dt = _Planetes[i].DateEtHeureDeLecture ;
                    }
                }
            }
            return dt ;
        }
        public bool PourChaquePlaneteDuSysteme_Faire( FonctionDeParcoursPlanetes fonction )
        {
            for( int p = 1 ; p <= Valeurs.maxPlanete ; ++p )
            {
                if ( PlaneteNonNulle( p ) )
                {
                    if ( ! fonction( this[p] ) )
                        return false ;
                }
            }
            return true ;
        }
        static public explicit operator String( Systeme s )
        {
            String r = "" ;
            r += @"
Galaxie
		
	
Système solaire
		
Système solaire " + s.galaxie + ":" + s.systeme + @"
Pos 	Planète 	Nom (Activité) 	Lune 	Débris 	Joueur (Statut) 	Alliance 	Actions
" ;
            int compte = 0 ;
            for( int p = 1 ; p <= Valeurs.maxPlanete ; ++p )
            {
                if ( s.PlaneteNonNulle( p ) )
                {
                    ++compte ;
                    r += "" + p + " \t\t"
                        + s[p].Nom + " \t"
                        + "\t" // Lune
                        + "\t" // Débris
                        + s[p].Joueur + " \t"
                        + s[p].Alliance + " \t"
                        + "Espionner Envoyer un message Demander à être ami\r\n" ;
                }
                else
                {
                    r += "" + p + " \t\t\t\t\t\t\t\r\n" ;
                }
            }
            r += "(" + compte + " planètes colonisées)\tLégende"+ @"
Légende
Joueur fort	f
Joueur faible (débutant)	d
Mode vacances	v
Bloqué	b
Inactif 7 jours	i
Inactif 28 jours	I
" ;
            return r ;
        }
    }
    [Serializable]
    public class Galaxie
    {
        private int _galaxie ;
        public int galaxie
        {
            get {
                return _galaxie ;
            }
            set {
                _galaxie = value ;
            }
        }
        private Systeme[] _Systemes ;
        public Systeme this[ int s ]
        {
            get {
                if ( s < 1 || s > Valeurs.maxSysteme ) throw new Exception("Un numéro de système est compris entre 1 et "+Valeurs.maxSysteme+".") ;
                if ( _Systemes[s] == null )
                {
                    _Systemes[s] = new Systeme() ;
                    _Systemes[s].galaxie = galaxie ;
                    _Systemes[s].systeme = s ;
                }
                return _Systemes[s] ;
            }
            set {
                if ( s < 1 || s > Valeurs.maxSysteme ) throw new Exception("Un numéro de système est compris entre 1 et "+Valeurs.maxSysteme+".") ;
                if ( value == null )
                {
                    _Systemes[s] = new Systeme() ;
                    _Systemes[s].galaxie = galaxie ;
                    _Systemes[s].systeme = s ;
                }
                else
                {
                    _Systemes[s] = value ;
                    _Systemes[s].galaxie = galaxie ;
                    _Systemes[s].systeme = s ;
                }
            }
        }
        public Galaxie()
        {
            _Systemes = new Systeme[Valeurs.maxSysteme+1] ;
        }
        public bool SystemeNonNul( int s )
        {
            if ( s < 1 || s > Valeurs.maxSysteme ) throw new Exception("Un numéro de système est compris entre 1 et "+Valeurs.maxSysteme+".") ;
            return _Systemes[s] != null ;
        }
        public int NombreDeSystemesNonNuls()
        {
            int compte = 0 ;
            for ( int i = 1 ; i <= Valeurs.maxSysteme ; ++i )
            {
                if ( _Systemes[i] != null )
                {
                    ++compte ;
                }
            }
            return compte ;
        }
        public bool PourChaquePlaneteDeLaGalaxie_Faire( FonctionDeParcoursPlanetes fonction )
        {
            foreach( Systeme s in _Systemes )
            {
                if ( s != null )
                {
                    if ( !s.PourChaquePlaneteDuSysteme_Faire( fonction ) )
                        return false ;
                }
            }
            return true ;
        }
        public bool PourChaqueSystemeDeLaGalaxie_Faire( FonctionDeParcoursSystemes fonction )
        {
            for( int s = 1 ; s <= Valeurs.maxSysteme ; ++s )
            {
                if ( SystemeNonNul( s ) )
                {
                    if ( ! fonction( this[s] ) )
                        return false ;
                }
            }
            return true ;
        }
    }
    [Serializable]
    public class Univers
    {
        private Galaxie[] _Galaxies ;
        public Univers()
        {
            _Galaxies = new Galaxie[Valeurs.maxGalaxie+1] ;
        }
        public Galaxie this[int g]
        {
            get {
                if ( g < 1 || g > Valeurs.maxGalaxie ) throw new Exception("Un numéro de galaxie est compris entre 1 et "+Valeurs.maxGalaxie+".") ;
                if ( _Galaxies[g] == null )
                {
                    _Galaxies[g] = new Galaxie() ;
                    _Galaxies[g].galaxie = g ;
                }
                return _Galaxies[g] ;
            }
            set {
                if ( g < 1 || g > Valeurs.maxGalaxie ) throw new Exception("Un numéro de galaxie est compris entre 1 et "+Valeurs.maxGalaxie+".") ;
                if ( value == null )
                {
                    _Galaxies[g] = new Galaxie() ;
                    _Galaxies[g].galaxie = g ;
                }
                else
                {
                    _Galaxies[g] = value ;
                    _Galaxies[g].galaxie = g ;
                }
            }
        }
        public Systeme this[int g, int s]
        {
            get {
                if ( g < 1 || g > Valeurs.maxGalaxie ) throw new Exception("Un numéro de galaxie est compris entre 1 et "+Valeurs.maxGalaxie+".") ;
                if ( s < 1 || s > Valeurs.maxSysteme ) throw new Exception("Un numéro de système est compris entre 1 et "+Valeurs.maxSysteme+".") ;
                return this[g][s] ;
            }
            set {
                if ( g < 1 || g > Valeurs.maxGalaxie ) throw new Exception("Un numéro de galaxie est compris entre 1 et "+Valeurs.maxGalaxie+".") ;
                if ( s < 1 || s > Valeurs.maxSysteme ) throw new Exception("Un numéro de système est compris entre 1 et "+Valeurs.maxSysteme+".") ;
                if ( value == null )
                {
                     this[g][s] = new Systeme() ;
                }
                else
                {
                     this[g][s] = value ;
                }
            }
        }
        public Planete this[int g, int s, int p]
        {
            get {
                if ( g < 1 || g > Valeurs.maxGalaxie ) throw new Exception("Un numéro de galaxie est compris entre 1 et "+Valeurs.maxGalaxie+".") ;
                if ( s < 1 || s > Valeurs.maxSysteme ) throw new Exception("Un numéro de système est compris entre 1 et "+Valeurs.maxSysteme+".") ;
                if ( p < 1 || p > Valeurs.maxPlanete ) throw new Exception("Un numéro de planète est compris entre 1 et "+Valeurs.maxPlanete+".") ;
                return this[g][s][p] ;
            }
            set {
                if ( g < 1 || g > Valeurs.maxGalaxie ) throw new Exception("Un numéro de galaxie est compris entre 1 et "+Valeurs.maxGalaxie+".") ;
                if ( s < 1 || s > Valeurs.maxSysteme ) throw new Exception("Un numéro de système est compris entre 1 et "+Valeurs.maxSysteme+".") ;
                if ( p < 1 || p > Valeurs.maxPlanete ) throw new Exception("Un numéro de planète est compris entre 1 et "+Valeurs.maxPlanete+".") ;
                if ( value == null )
                {
                    this[g][s][p] = new Planete() ;
                }
                else
                {
                    this[g][s][p] = value ;
                }
            }
        }
        public Planete this[Coordonnees c]
        {
            get {
                //if ( c.Type != TypeDeCoordonnees.Planete ) throw new Exception("Seules les planètes sont prises en compte...") ;
                return this[c.Galaxie][c.Systeme][c.Planete] ;
            }
            set {
                //if ( c.Type != TypeDeCoordonnees.Planete ) throw new Exception("Seules les planètes sont prises en compte...") ;
                if ( value == null )
                {
                    this[c.Galaxie][c.Systeme][c.Planete] = new Planete() ;
                }
                else
                {
                    this[c.Galaxie][c.Systeme][c.Planete] = value ;
                }
            }
        }
        public bool GalaxieNonNulle( int g )
        {
                if ( g < 1 || g > Valeurs.maxGalaxie ) throw new Exception("Un numéro de galaxie est compris entre 1 et "+Valeurs.maxGalaxie+".") ;
            return _Galaxies[g] != null ;
        }

        public bool PourChaquePlaneteDeLUnivers_Faire( FonctionDeParcoursPlanetes fonction )
        {
            foreach( Galaxie g in _Galaxies )
            {
                if ( g != null )
                {
                    if ( !g.PourChaquePlaneteDeLaGalaxie_Faire( fonction ) )
                        return false ;
                }
            }
            return true ;
        }

        public bool PourChaqueSystemeDeLUnivers_Faire( FonctionDeParcoursSystemes fonction )
        {
            foreach( Galaxie g in _Galaxies )
            {
                if ( g != null )
                {
                    if ( !g.PourChaqueSystemeDeLaGalaxie_Faire( fonction ) )
                        return false ;
                }
            }
            return true ;
        }

        private Systeme recupererSysteme( string copieDUnSysteme )
        {
            Regex r1 = new Regex( @"^Système solaire\s*(\d{1,3}):\d{1,3}\s*$", RegexOptions.IgnoreCase | RegexOptions.Multiline );
            Regex r2 = new Regex( @"^Système solaire\s*\d{1,3}:(\d{1,3})\s*$", RegexOptions.IgnoreCase | RegexOptions.Multiline );
            Match m1 = r1.Match( copieDUnSysteme );
            Match m2 = r2.Match( copieDUnSysteme );
            if ( m1.Success && m2.Success )
            {
                int g = Convert.ToInt32( m1.Groups[1].Value ) ;
                int s = Convert.ToInt32( m2.Groups[1].Value ) ;
                return this[g, s] ;
            }
            throw new Exception("La copie n'est pas une copie valide de système. (détermination des coordonnées du système)") ;
        }
        
        private int numeroDeLaLigneDeTitreDuTableauDuSysteme( string[] lignes )
        {
            Regex r = new Regex( @"^Pos\s*Planète\s*Nom", RegexOptions.IgnoreCase | RegexOptions.Multiline );
            for ( int i = 0 ; i < lignes.Length ; ++i )
            {
                Match m = r.Match( lignes[i] );
                if ( m.Success )
                {
                    return i ;
                }
            }
            throw new Exception("La copie n'est pas une copie valide de système. (problème entête du tableau)") ;
        }

        private void lirePlanete( Systeme sys, string lignePlanete )
        {
            Planete p = new Planete() ;
            string[] items = lignePlanete.Split('\t') ;
            if ( items.Length != 8 ) throw new Exception("Lecture d'une planète : pas assez d'items. Utilisez Firefox pour lire les systèmes.") ;
            int position = Convert.ToInt32( items[0] ) ;

            #region Récupération du nom de la planète
            {
                Regex r = new Regex( @"^([a-zA-Z0-9éè _-]*[a-zA-Z0-9éè_-])\s*", RegexOptions.IgnoreCase | RegexOptions.Multiline );
                Match m = r.Match( items[2] ) ;
                if ( m.Success )
                {
                    sys[position].Nom = m.Groups[1].Value.Trim() ;
                }
                else
                {
                    sys[position].Nom = "" ;
                }
            }
            #endregion
            #region Récupération du nom du joueur
            {
                Regex r = new Regex( @"^([a-zA-Z0-9 _-]*[a-zA-Z0-9_-])\s*(\([diIvb ]*\))?", RegexOptions.IgnoreCase | RegexOptions.Multiline );
                Match m = r.Match( items[5] ) ;
                if ( m.Success )
                {
                    sys[position].Joueur = m.Groups[1].Value.Trim() ;
                }
                else
                {
                    sys[position].Joueur = "" ;
                }
            }
            #endregion
            #region Récupération du status du joueur
            {
                Regex r = new Regex( @"^[a-zA-Z0-9 _-]*[a-zA-Z0-9_-]\s*(\([diIvb ]*\))?", RegexOptions.IgnoreCase | RegexOptions.Multiline );
                Match m = r.Match( items[5] ) ;
                if ( m.Success )
                {
                    sys[position].Status = Utils.lireStatus( m.Groups[1].Value ) ;
                }
            }
            #endregion
            #region Récupération de la date et de l'heure courantes
            sys[position].DateEtHeureDeLecture = DateTime.Now;
            #endregion
            #region Récupération du nom de l'alliance
            sys[position].Alliance = items[6] ;
            #endregion
            #region Récupération de la présence de la lune
            if ( items[3].Contains("M") )
            {
                sys[position].AUneLune = true ;
            }
            #endregion
        }

        public Systeme lireSysteme( string copieDUnSysteme )
        {
            Systeme s = recupererSysteme( copieDUnSysteme ) ;
            string[] separateurs = new string[1] ;
            separateurs[0] = "\r\n" ;
            string[] lignes = copieDUnSysteme.Split(separateurs, StringSplitOptions.None) ;
            int l = numeroDeLaLigneDeTitreDuTableauDuSysteme( lignes ) ;
            for ( int i = 0 ; i < 15 ; ++i )
            {
                ++l ;
                lirePlanete( s, lignes[l] ) ;
            }
            return s ;
        }

    }

    public class empire
    {
        static private string ChercheLaLigneQuiCommencePar( string texte, string debut )
        {
            Regex r = new Regex( @"^" + debut + @"\s*(\S.*\S)\s*$", RegexOptions.IgnoreCase | RegexOptions.Multiline );
            Match m = r.Match( texte );
            if ( m.Success )
            {
                return m.Groups[1].Value ;
            }
            return "0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0" ;
        }

        static public Collection<RapportDEspionnage> lireEmpire(string empire)
        {
            Collection<RapportDEspionnage> Empire = new Collection<RapportDEspionnage>() ;
            string lignesCoordonnees = ChercheLaLigneQuiCommencePar(empire, "Coordonnées") ;
            char[] limites = new char[2] ;
            limites[0] = ' ' ; limites[1] = '\t' ;
            string[] tmp ;
            tmp = lignesCoordonnees.Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
            for ( int i = 0 ; i < tmp.Length ; ++i )
            {
                Empire.Add( new RapportDEspionnage() ) ;
            }
            for ( int i = 0 ; i < Empire.Count ; ++i )
            {
                Empire[i].Coordonnees = tmp[i] ;
            }
            try
            {
                // Flotte à quai
                #region Petits transporteurs
                tmp = ChercheLaLigneQuiCommencePar(empire, "Petit transporteur").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.PetitsTransporteurs = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Grands transporteurs
                tmp = ChercheLaLigneQuiCommencePar(empire, "Grand transporteur").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.GrandTransporteurs = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Chasseur léger
                tmp = ChercheLaLigneQuiCommencePar(empire, "Chasseur léger").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.ChasseursLegers = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Chasseur lourds
                tmp = ChercheLaLigneQuiCommencePar(empire, "Chasseur lourd").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.ChasseursLourds = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Croiseurs
                tmp = ChercheLaLigneQuiCommencePar(empire, "Croiseur").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.Croiseurs = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Vaisseaux de bataille
                tmp = ChercheLaLigneQuiCommencePar(empire, "Vaisseau de bataille").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.VaisseauxDeBataille = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Vaisseaux de colonisation
                tmp = ChercheLaLigneQuiCommencePar(empire, "Vaisseau de colonisation").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.VaisseauxDeColonisation = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Recycleurs
                tmp = ChercheLaLigneQuiCommencePar(empire, "Recycleur").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.Recycleurs = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Sondes d'espionnage
                tmp = ChercheLaLigneQuiCommencePar(empire, "Sonde espionnage").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.SondesDEspionnage = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Bombardiers
                tmp = ChercheLaLigneQuiCommencePar(empire, "Bombardier").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.Bombardiers = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Satellites solaires
                tmp = ChercheLaLigneQuiCommencePar(empire, "Satellite solaire").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.SatellitesSolaires = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Destructeurs
                tmp = ChercheLaLigneQuiCommencePar(empire, "Destructeur").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.Destructeurs = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                #region Étoiles de la mort
                tmp = ChercheLaLigneQuiCommencePar(empire, "Étoile de la mort").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                for ( int i = 0 ; i < Empire.Count ; ++i )
                {
                    Empire[i].FlotteAQuai.EtoilesDeLaMort = System.Convert.ToUInt32( tmp[i] ) ;
                }
                #endregion
                // Technologies
                #region Technologie Espionnage
                tmp = ChercheLaLigneQuiCommencePar( empire, "Technologie Espionnage" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Espionnage = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region  Technologie Ordinateur
                tmp = ChercheLaLigneQuiCommencePar( empire, " Technologie Ordinateur" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Ordinateur = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region Technologie Armes
                tmp = ChercheLaLigneQuiCommencePar(empire, "Technologie Armes").Split( limites, StringSplitOptions.RemoveEmptyEntries ) ;
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Armes = System.Convert.ToUInt32( s ) ;
                        }
                        break ;
                    }
                }
                #endregion
                #region  Technologie Bouclier
                tmp = ChercheLaLigneQuiCommencePar( empire, "Technologie Bouclier" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Bouclier = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region  Technologie Protection des vaisseaux spatiaux
                tmp = ChercheLaLigneQuiCommencePar( empire, "Technologie Protection des vaisseaux spatiaux" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.ProtectionDesVaisseauxSpatiaux = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region Technologie Energie
                tmp = ChercheLaLigneQuiCommencePar( empire, "Technologie Energie" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Energie = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region  Technologie Hyperespace
                tmp = ChercheLaLigneQuiCommencePar( empire, "Technologie Hyperespace" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Hyperespace = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region  Réacteur à combustion
                tmp = ChercheLaLigneQuiCommencePar( empire, "Réacteur à combustion" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.ReacteurACombustion = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region Réacteur à impulsion
                tmp = ChercheLaLigneQuiCommencePar( empire, "Réacteur à impulsion" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.ReacteurAImpulsion = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region Propulsion hyperespace
                tmp = ChercheLaLigneQuiCommencePar( empire, "Propulsion hyperespace" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.PropulsionHyperespace = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region Technologie Laser
                tmp = ChercheLaLigneQuiCommencePar( empire, "Technologie Laser" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Laser = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region Technologie Ions
                tmp = ChercheLaLigneQuiCommencePar( empire, "Technologie Ions" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Ions = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region Technologie Plasma
                tmp = ChercheLaLigneQuiCommencePar( empire, "Technologie Plasma" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Plasma = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region Réseau de recherche intergalactique
                tmp = ChercheLaLigneQuiCommencePar( empire, "Réseau de recherche intergalactique" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.ReseauDeRechercheIntergalactique = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
                #region Technologie Graviton
                tmp = ChercheLaLigneQuiCommencePar( empire, "Technologie Graviton" ).Split( limites, StringSplitOptions.RemoveEmptyEntries );
                foreach ( string s in tmp )
                {
                    if ( s != "-" )
                    {
                        foreach ( RapportDEspionnage r in Empire )
                        {
                            r.Recherches.Graviton = System.Convert.ToUInt32( s );
                        }
                        break;
                    }
                }
                #endregion
            }
            catch( Exception )
            {
                return new Collection<RapportDEspionnage>() ;
            }
            return Empire ;
        }
    }

    public enum VainqueurDeCombat
    {
        Attaquant, Defenseur, Nul
    }

    [Serializable]
    public class ResultatsDeSimulationMassive : System.Collections.Hashtable
    {
        public StatistiquesDeSimulation this[ Coordonnees c ]
        {
            get {
                return (this[(object)c] as StatistiquesDeSimulation) ;
            } 
            set {
                this.Add( c, value ) ;
            } 
        }
        public ResultatsDeSimulationMassive()
        {
        }
    }

    [Serializable]
    public class StatistiquesDeSimulation
    {
        private int _NombreDeSimulations;
        public int NombreDeSimulations
        {
            get { return _NombreDeSimulations; }
            set { _NombreDeSimulations = value; }
        }
        private int _NombreDeTours ;
        public double NombreDeTours
        {
            get { return (double)_NombreDeTours/NombreDeSimulations ; }
        }
        private int _NombreDeCombatsGagnes ; // Par l'attaquant
        public int NombreDeCombatsGagnes
        {
            get { return _NombreDeCombatsGagnes; }
            set { _NombreDeCombatsGagnes = value; }
        }
        private int _NombreDeCombatsNuls   ;
        public int NombreDeCombatsNuls
        {
            get { return _NombreDeCombatsNuls; }
            set { _NombreDeCombatsNuls = value; }
        }
        private int _NombreDeCombatsPerdus ; // Par l'attaquant
        public int NombreDeCombatsPerdus
        {
            get { return _NombreDeCombatsPerdus; }
            set { _NombreDeCombatsPerdus = value; }
        }
        private RessourcesLong _Pillage ;
        public RessourcesLong Pillage
        {
            get {
                if ( _NombreDeCombatsGagnes == 0 ) return new RessourcesLong() ;
                return _Pillage/_NombreDeCombatsGagnes ;
            }
        }
        private RessourcesLong _Ruines ;
        public RessourcesLong Ruines
        {
            get {
                if ( NombreDeSimulations == 0 ) return new RessourcesLong() ;
                return _Ruines/NombreDeSimulations ;
            }
        }
        private RessourcesLong _PertesAttaquant ;
        public RessourcesLong PertesAttaquant
        {
            get {
                if ( NombreDeSimulations == 0 ) return new RessourcesLong() ;
                return _PertesAttaquant/NombreDeSimulations ;
            }
        }
        private RessourcesLong _PertesDefenseur ;
        public RessourcesLong PertesDefenseur
        {
            get { return _PertesDefenseur/NombreDeSimulations ; }
            set { _PertesDefenseur = value; }
        }
        private RessourcesLong _GainAttaquantSansRecyclage ;
        public RessourcesLong GainAttaquantSansRecyclage
        {
            get {
                if ( NombreDeSimulations == 0 ) return new RessourcesLong() ;
                return _GainAttaquantSansRecyclage/NombreDeSimulations ;
            }
        }
        private RessourcesLong _GainAttaquantAvecRecyclage ;
        public RessourcesLong GainAttaquantAvecRecyclage
        {
            get {
                if ( NombreDeSimulations == 0 ) return new RessourcesLong() ;
                return _GainAttaquantAvecRecyclage/NombreDeSimulations ;
            }
        }
        private RessourcesLong _RentabiliteAttaquantSansRecyclage ;
        public RessourcesLong RentabiliteAttaquantSansRecyclage
        {
            get {
                if ( NombreDeSimulations == 0 ) return new RessourcesLong() ;
                return _RentabiliteAttaquantSansRecyclage/NombreDeSimulations ;
            }
        }
        private RessourcesLong _RentabiliteAttaquantAvecRecyclage ;
        public RessourcesLong RentabiliteAttaquantAvecRecyclage
        {
            get {
                if ( NombreDeSimulations == 0 ) return new RessourcesLong() ;
                return _RentabiliteAttaquantAvecRecyclage/NombreDeSimulations ;
            }
        }
        private RessourcesLong _RentabiliteDefenseurSansRecyclage ;
        public RessourcesLong RentabiliteDefenseurSansRecyclage
        {
            get {
                if ( NombreDeSimulations == 0 ) return new RessourcesLong() ;
                return _RentabiliteDefenseurSansRecyclage/NombreDeSimulations ;
            }
        }
        private RessourcesLong _RentabiliteDefenseurAvecRecyclage ;
        public RessourcesLong RentabiliteDefenseurAvecRecyclage
        {
            get {
                if ( NombreDeSimulations == 0 ) return new RessourcesLong() ;
                return _RentabiliteDefenseurAvecRecyclage/NombreDeSimulations ;
            }
        }
        private RessourcesLong _Consommation ;
        public RessourcesLong Consommation
        {
            get {
                if ( NombreDeSimulations == 0 ) return new RessourcesLong() ;
                return _Consommation/NombreDeSimulations ;
            }
        }

        private long _TempsDeTrajet ;
        public long TempsDeTrajet
        {
            get { return _TempsDeTrajet ; }
        }

        private ResultatDeCombat _PireCas ;
        public ResultatDeCombat PireCas
        {
            get { return _PireCas ; }
        }
        private ResultatDeCombat _MeilleurCas ;
        public ResultatDeCombat MeilleurCas
        {
            get { return _MeilleurCas ; }
        }

        public StatistiquesDeSimulation()
        {
            NombreDeSimulations = 0 ;
            _NombreDeTours = 0 ;
            _NombreDeCombatsGagnes = 0 ;
            _NombreDeCombatsNuls   = 0 ;
            _NombreDeCombatsPerdus = 0 ;
            _Pillage = new RessourcesLong() ;
            _Ruines = new RessourcesLong() ;
            _PertesAttaquant = new RessourcesLong() ;
            _PertesDefenseur = new RessourcesLong() ;
            _GainAttaquantSansRecyclage = new RessourcesLong() ;
            _GainAttaquantAvecRecyclage = new RessourcesLong() ;
            _RentabiliteAttaquantSansRecyclage = new RessourcesLong() ;
            _RentabiliteAttaquantAvecRecyclage = new RessourcesLong() ;
            _RentabiliteDefenseurSansRecyclage = new RessourcesLong() ;
            _RentabiliteDefenseurAvecRecyclage = new RessourcesLong() ;
            _Consommation = new RessourcesLong() ;
            _PireCas = ResultatDeCombat.LeMeilleur ;
            _MeilleurCas = ResultatDeCombat.LePire ;
            _TempsDeTrajet = 0 ;
        }

        public StatistiquesDeSimulation(StatistiquesDeSimulation source)
        {
            this.NombreDeSimulations = source._NombreDeSimulations ;
            this._NombreDeTours = source._NombreDeTours ;
            this._NombreDeCombatsGagnes = source._NombreDeCombatsGagnes ;
            this._NombreDeCombatsNuls   = source._NombreDeCombatsNuls   ;
            this._NombreDeCombatsPerdus = source._NombreDeCombatsPerdus ;
            this._Pillage = new RessourcesLong( source._Pillage ) ;
            this._Ruines = new RessourcesLong( source._Ruines ) ;
            this._PertesAttaquant = new RessourcesLong( source._PertesAttaquant ) ;
            this._PertesDefenseur = new RessourcesLong( source._PertesDefenseur ) ;
            this._GainAttaquantSansRecyclage = new RessourcesLong( source._GainAttaquantSansRecyclage ) ;
            this._GainAttaquantAvecRecyclage = new RessourcesLong( source._GainAttaquantAvecRecyclage ) ;
            this._RentabiliteAttaquantSansRecyclage = new RessourcesLong( source._RentabiliteAttaquantSansRecyclage ) ;
            this._RentabiliteAttaquantAvecRecyclage = new RessourcesLong( source._RentabiliteAttaquantAvecRecyclage ) ;
            this._RentabiliteDefenseurSansRecyclage = new RessourcesLong( source._RentabiliteDefenseurSansRecyclage ) ;
            this._RentabiliteDefenseurAvecRecyclage = new RessourcesLong( source._RentabiliteDefenseurAvecRecyclage ) ;
            this._Consommation = new RessourcesLong( source._Consommation ) ;
            this._PireCas = new ResultatDeCombat( source._PireCas ) ;
            this._MeilleurCas = new ResultatDeCombat( source._MeilleurCas ) ;
            this._TempsDeTrajet = source._TempsDeTrajet ;
        }
        
        public StatistiquesDeSimulation AjouteUnResultat( ResultatDeCombat r )
        {
            if ( r != null )
            {
                NombreDeSimulations += 1 ;
                _NombreDeTours += r.NombreDeTours ;
                switch ( r.Vainqueur )
                {
                    case VainqueurDeCombat.Attaquant : _NombreDeCombatsGagnes += 1 ; break ;
                    case VainqueurDeCombat.Defenseur : _NombreDeCombatsPerdus += 1 ; break ;
                    case VainqueurDeCombat.Nul       : _NombreDeCombatsNuls   += 1 ; break ;
                }
                _Pillage += r.Pillage ;
                _Ruines += r.Ruines ;
                _PertesAttaquant += r.PertesAttaquant ; 
                _PertesDefenseur += r.PertesDefenseur ;
                _GainAttaquantSansRecyclage += r.GainAttaquantSansRecyclage ;
                _GainAttaquantAvecRecyclage += r.GainAttaquantAvecRecyclage ;
                _RentabiliteAttaquantSansRecyclage += r.RentabiliteAttaquantSansRecyclage ;
                _RentabiliteAttaquantAvecRecyclage += r.RentabiliteAttaquantAvecRecyclage ;
                _RentabiliteDefenseurSansRecyclage += r.RentabiliteDefenseurSansRecyclage ;
                _RentabiliteDefenseurAvecRecyclage += r.RentabiliteDefenseurAvecRecyclage ;
                _Consommation += r.Consommation ;
                _TempsDeTrajet = r.TempsDeTrajet ;

                // Mise à jour du pire cas
                if ( r.PertesAttaquant.Total > PireCas.PertesAttaquant.Total ) PireCas.PertesAttaquant.copie( r.PertesAttaquant ) ;
                if ( r.PertesDefenseur.Total < PireCas.PertesDefenseur.Total ) PireCas.PertesDefenseur.copie( r.PertesDefenseur ) ;
                if ( r.Pillage.Total < PireCas.Pillage.Total ) PireCas.Pillage.copie( r.Pillage ) ;
                if ( r.GainAttaquantAvecRecyclage.Total < PireCas.GainAttaquantAvecRecyclage.Total ) PireCas.GainAttaquantAvecRecyclage.copie( r.GainAttaquantAvecRecyclage ) ;
                if ( r.GainAttaquantSansRecyclage.Total < PireCas.GainAttaquantSansRecyclage.Total ) PireCas.GainAttaquantSansRecyclage.copie( r.GainAttaquantSansRecyclage ) ;
                if ( r.RentabiliteAttaquantAvecRecyclage.Total < PireCas.RentabiliteAttaquantAvecRecyclage.Total ) PireCas.RentabiliteAttaquantAvecRecyclage.copie( r.RentabiliteAttaquantAvecRecyclage ) ;
                if ( r.RentabiliteAttaquantSansRecyclage.Total < PireCas.RentabiliteAttaquantSansRecyclage.Total ) PireCas.RentabiliteAttaquantSansRecyclage.copie( r.RentabiliteAttaquantSansRecyclage ) ;
                if ( r.RentabiliteDefenseurAvecRecyclage.Total > PireCas.RentabiliteDefenseurAvecRecyclage.Total ) PireCas.RentabiliteDefenseurAvecRecyclage.copie( r.RentabiliteDefenseurAvecRecyclage ) ;
                if ( r.RentabiliteDefenseurSansRecyclage.Total > PireCas.RentabiliteDefenseurSansRecyclage.Total ) PireCas.RentabiliteDefenseurSansRecyclage.copie( r.RentabiliteDefenseurSansRecyclage ) ;
                if ( r.Ruines.Total < PireCas.Ruines.Total ) PireCas.Ruines.copie( r.Ruines ) ;
                if ( r.NombreDeTours > PireCas.NombreDeTours ) PireCas.NombreDeTours = r.NombreDeTours ;
                // Mise à jour du meilleur cas
                if ( r.PertesAttaquant.Total < MeilleurCas.PertesAttaquant.Total ) MeilleurCas.PertesAttaquant.copie( r.PertesAttaquant ) ;
                if ( r.PertesDefenseur.Total > MeilleurCas.PertesDefenseur.Total ) MeilleurCas.PertesDefenseur.copie( r.PertesDefenseur ) ;
                if ( r.Pillage.Total > MeilleurCas.Pillage.Total ) MeilleurCas.Pillage.copie( r.Pillage ) ;
                if ( r.GainAttaquantAvecRecyclage.Total > PireCas.GainAttaquantAvecRecyclage.Total ) MeilleurCas.GainAttaquantAvecRecyclage.copie( r.GainAttaquantAvecRecyclage ) ;
                if ( r.GainAttaquantSansRecyclage.Total > PireCas.GainAttaquantSansRecyclage.Total ) MeilleurCas.GainAttaquantSansRecyclage.copie( r.GainAttaquantSansRecyclage ) ;
                if ( r.RentabiliteAttaquantAvecRecyclage.Total > MeilleurCas.RentabiliteAttaquantAvecRecyclage.Total ) MeilleurCas.RentabiliteAttaquantAvecRecyclage.copie( r.RentabiliteAttaquantAvecRecyclage ) ;
                if ( r.RentabiliteAttaquantSansRecyclage.Total > MeilleurCas.RentabiliteAttaquantSansRecyclage.Total ) MeilleurCas.RentabiliteAttaquantSansRecyclage.copie( r.RentabiliteAttaquantSansRecyclage ) ;
                if ( r.RentabiliteDefenseurAvecRecyclage.Total < MeilleurCas.RentabiliteDefenseurAvecRecyclage.Total ) MeilleurCas.RentabiliteDefenseurAvecRecyclage.copie( r.RentabiliteDefenseurAvecRecyclage ) ;
                if ( r.RentabiliteDefenseurSansRecyclage.Total < MeilleurCas.RentabiliteDefenseurSansRecyclage.Total ) MeilleurCas.RentabiliteDefenseurSansRecyclage.copie( r.RentabiliteDefenseurSansRecyclage ) ;
                if ( r.Ruines.Total > MeilleurCas.Ruines.Total ) MeilleurCas.Ruines.copie( r.Ruines ) ;
                if ( r.NombreDeTours < MeilleurCas.NombreDeTours ) MeilleurCas.NombreDeTours = r.NombreDeTours ;
            }
            return this ;
        }
        
        public static StatistiquesDeSimulation operator+(StatistiquesDeSimulation stat, ResultatDeCombat r)
        {
            StatistiquesDeSimulation s = new StatistiquesDeSimulation( stat ) ;
            return s.AjouteUnResultat( r ) ;
        }
    }

    [Serializable]
    public class ResultatDeCombat
    {
        public class StatistiqueDeTour
        {
            public class Stats
            {
                public uint NombreDeTirs ;
                public uint DegatsAbsorbesParLesBoucliers ;
                public uint DegatsInfliges ;
            }
            public Stats TirsDuDefenseur ;
            public Stats TirsDeLAttaquant ;
        }

        public int NombreDeTours ;
        public VainqueurDeCombat Vainqueur ;
        public Ressources Pillage ;
        public Ressources Ruines ;
        public Ressources PertesAttaquant ;
        public Ressources PertesDefenseur ;
        public StatistiqueDeTour[] Statistiques ;
        public RessourcesLong GainAttaquantSansRecyclage ;
        public RessourcesLong GainAttaquantAvecRecyclage ;
        public RessourcesLong RentabiliteAttaquantSansRecyclage ;
        public RessourcesLong RentabiliteAttaquantAvecRecyclage ;
        public RessourcesLong RentabiliteDefenseurSansRecyclage ;
        public RessourcesLong RentabiliteDefenseurAvecRecyclage ;
        public Ressources Consommation ;
        public long TempsDeTrajet ;

        public ResultatDeCombat()
        {
            Vainqueur = VainqueurDeCombat.Nul ;
            Pillage = new Ressources() ;
            Ruines = new Ressources() ;
            PertesAttaquant = new Ressources() ;
            PertesDefenseur = new Ressources() ;
            Statistiques = new StatistiqueDeTour[6] ;
            GainAttaquantAvecRecyclage = new RessourcesLong() ;
            GainAttaquantSansRecyclage = new RessourcesLong() ;
            RentabiliteAttaquantSansRecyclage = new RessourcesLong() ;
            RentabiliteAttaquantAvecRecyclage = new RessourcesLong() ;
            RentabiliteDefenseurSansRecyclage = new RessourcesLong() ;
            RentabiliteDefenseurAvecRecyclage = new RessourcesLong() ;
            Consommation = new Ressources() ;
        }
        
        public ResultatDeCombat( ResultatDeCombat source )
        {
            Vainqueur = source.Vainqueur ;
            Pillage = new Ressources( source.Pillage ) ;
            Ruines = new Ressources( source.Ruines ) ;
            PertesAttaquant = new Ressources( source.PertesAttaquant ) ;
            PertesDefenseur = new Ressources( source.PertesDefenseur ) ;
            Statistiques = new StatistiqueDeTour[6] ; //TODO: copier les stats de la source
            GainAttaquantAvecRecyclage = new RessourcesLong( source.GainAttaquantAvecRecyclage ) ;
            GainAttaquantSansRecyclage = new RessourcesLong( source.GainAttaquantSansRecyclage ) ;
            RentabiliteAttaquantSansRecyclage = new RessourcesLong( source.RentabiliteAttaquantSansRecyclage ) ;
            RentabiliteAttaquantAvecRecyclage = new RessourcesLong( source.RentabiliteAttaquantAvecRecyclage ) ;
            RentabiliteDefenseurSansRecyclage = new RessourcesLong( source.RentabiliteDefenseurSansRecyclage ) ;
            RentabiliteDefenseurAvecRecyclage = new RessourcesLong( source.RentabiliteDefenseurAvecRecyclage ) ;
            Consommation = new Ressources( source.Consommation ) ;
        }
        
        public static ResultatDeCombat LePire
        {
            get {
                ResultatDeCombat r = new ResultatDeCombat() ;
                r.PertesAttaquant = Ressources.Maximum ;
                r.Ruines = Ressources.Minimum ;
                r.Pillage = Ressources.Minimum ;
                r.RentabiliteAttaquantAvecRecyclage = RessourcesLong.Minimum ;
                r.RentabiliteAttaquantSansRecyclage = RessourcesLong.Minimum ;
                r.RentabiliteDefenseurAvecRecyclage = RessourcesLong.Maximum ;
                r.RentabiliteDefenseurSansRecyclage = RessourcesLong.Maximum ;
                r.Vainqueur = VainqueurDeCombat.Defenseur ;
                r.NombreDeTours = 6 ;
                return r ;
            }
        }
        public static ResultatDeCombat LeMeilleur
        {
            get {
                ResultatDeCombat r = new ResultatDeCombat() ;
                r.PertesDefenseur = Ressources.Maximum ;
                r.Ruines = Ressources.Maximum ;
                r.Pillage = Ressources.Maximum ;
                r.RentabiliteAttaquantAvecRecyclage = RessourcesLong.Maximum ;
                r.RentabiliteAttaquantSansRecyclage = RessourcesLong.Maximum ;
                r.RentabiliteDefenseurAvecRecyclage = RessourcesLong.Minimum ;
                r.RentabiliteDefenseurSansRecyclage = RessourcesLong.Minimum ;
                r.Vainqueur = VainqueurDeCombat.Attaquant ;
                r.NombreDeTours = 1 ;
                return r ;
            }
        }

    }

    public class Simulateur
    {
        private string UniteToString( Unite u ) 
        {
            string s = "" ;
            switch ( u.type )
            {
                case TypeDUnite.PetitTransporteur       : s += "PetitTransporteur" ; break ;
                case TypeDUnite.GrandTransporteur       : s += "GrandTransporteur" ; break ;
                case TypeDUnite.ChasseurLeger           : s += "ChasseurLeger" ; break ;
                case TypeDUnite.ChasseurLourd           : s += "ChasseurLourd" ; break ;
                case TypeDUnite.Croiseur                : s += "Croiseur" ; break ;
                case TypeDUnite.VaisseauDeBataille      : s += "VaisseauDeBataille" ; break ;
                case TypeDUnite.VaisseauDeColonisation  : s += "VaisseauDeColonisation" ; break ;
                case TypeDUnite.Recycleur               : s += "Recycleur" ; break ;
                case TypeDUnite.Sonde                   : s += "Sonde" ; break ;
                case TypeDUnite.SatelliteSolaire        : s += "SatelliteSolaire" ; break ;
                case TypeDUnite.Bombardier              : s += "Bombardier" ; break ;
                case TypeDUnite.Destructeur             : s += "Destructeur" ; break ;
                case TypeDUnite.EtoileDeLaMort          : s += "EtoileDeLaMort" ; break ;
                case TypeDUnite.LanceurDeMissiles       : s += "LanceurDeMissiles" ; break ;
                case TypeDUnite.ArtillerieLaserLegere   : s += "ArtillerieLaserLegere" ; break ;
                case TypeDUnite.ArtillerieLaserLourde   : s += "ArtillerieLaserLourde" ; break ;
                case TypeDUnite.ArtillerieAIons         : s += "ArtillerieAIons" ; break ;
                case TypeDUnite.CanonDeGauss            : s += "CanonDeGauss" ; break ;
                case TypeDUnite.LanceurDePlasma         : s += "LanceurDePlasma" ; break ;
                case TypeDUnite.PetitBouclier           : s += "PetitBouclier" ; break ;
                case TypeDUnite.GrandBouclier           : s += "GrandBouclier" ; break ;
                case TypeDUnite.MissileDInterception    : s += "MissileDInterception" ; break ;
                case TypeDUnite.MissileInterplanetaire  : s += "MissileInterplanetaire" ; break ;
            }
            return s ;
        }

        
        static private System.Random r ;

        private RapportDEspionnage _DefenseurInitial ;
        private RapportDEspionnage _Defenseur ;
        public RapportDEspionnage Defenseur
        {
            get { return _Defenseur ; }
            set {
                _DefenseurInitial = value ;
                _Defenseur = new RapportDEspionnage( value ) ;
            }
        }

        private RapportDEspionnage _AttaquantInitial ;
        private RapportDEspionnage _Attaquant ;
        public RapportDEspionnage Attaquant
        {
            get { return _Attaquant ; }
            set {
                _AttaquantInitial = value ;
                _Attaquant = new RapportDEspionnage( value ) ;
            }
        }

        public Simulateur()
        {
            if ( r == null ) r = new Random() ;
            this.Attaquant = new RapportDEspionnage() ;
            this.Defenseur = new RapportDEspionnage() ;
        }

        public Simulateur( RapportDEspionnage Attaquant, RapportDEspionnage Defenseur )
        {
            if ( r == null ) r = new Random() ;
            this.Attaquant = new RapportDEspionnage( Attaquant ) ;
            this.Defenseur = new RapportDEspionnage( Defenseur ) ;
        }
        
        #region Tableaux de rapidfire et de caractéristiques des unites

        public enum TypeDUnite
        {
            PetitTransporteur      =  0 ,
            GrandTransporteur      =  1 ,
            ChasseurLeger          =  2 ,
            ChasseurLourd          =  3 ,
            Croiseur               =  4 ,
            VaisseauDeBataille     =  5 ,
            VaisseauDeColonisation =  6 ,
            Recycleur              =  7 ,
            Sonde                  =  8 ,
            SatelliteSolaire       =  9 ,
            Bombardier             = 10 ,
            Destructeur            = 11 ,
            Battlecruiser          = 12 ,
            EtoileDeLaMort         = 13 ,
            LanceurDeMissiles      = 14 ,
            ArtillerieLaserLegere  = 15 ,
            ArtillerieLaserLourde  = 16 ,
            ArtillerieAIons        = 17 ,
            CanonDeGauss           = 18 ,
            LanceurDePlasma        = 19 ,
            PetitBouclier          = 20 ,
            GrandBouclier          = 21 ,
            MissileDInterception   = 22 ,
            MissileInterplanetaire = 23
        }

        static private double[,] TableDesRapidFire = new double[,]
        {
/*   Unite détruite *//*   PT    GT    Cl    CL    CR    VB    VC    RC    SE    SS    BB    DS    BC    EM    LM    Ll    LL    AI    CG    LP    PB    GB */
/* Unite attaquante */                                                                             
/*               PT */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               GT */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               Cl */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               CL */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               CR */{    -1,   -1,83.333,  -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   90,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               VB */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               VC */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               RC */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               SE */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               SS */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               BB */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   95,   95,   90,   90,   -1,   -1,   -1,   -1  },
/*               DS */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   50,   -1,   -1,   90,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               BC */{ 66.667,66.667, -1,   75,   75, 85.7,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   90,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               EM */{  99.6, 99.6, 99.5,   99,96.97,99.667,99.6, 99.6, 99.6, 99.6,   96,   80,93.333,   0, 99.5, 99.5,   99,   99,   98,   -1,   -1,   -1  },
/*               LM */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               Ll */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               LL */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               AI */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               CG */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               LP */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               PB */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  },
/*               GB */{    -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   80,   80,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1  }
        } ;

        public enum TypeDeCaracteristique
        {
            Degats,
            Bouclier,
            Coque,
            Soute
        }

        static private uint[,] tableDesCaracteristiques = new uint[,]
        {
/* Caractéristique*//*     Degats  Bouclier     Coque    Soute */
/*               PT */{         5,       10,     4000,    5000 },
/*               GT */{         5,       25,    12000,   25000 },
/*               Cl */{        50,       10,     4000,      50 },
/*               CL */{       150,       25,    10000,     100 },
/*               CR */{       400,       50,    27000,     800 },
/*               VB */{      1000,      200,    60000,    1500 },
/*               VC */{        50,      100,    30000,    7500 },
/*               RC */{         1,       10,    16000,   20000 },
/*               SE */{         0,        0,     1000,       5 }, // /!\ Attention aux sondes, elles ne peuvent porter que ce qu'elles consomment.
/*               SS */{         1,        1,     2000,       0 },
/*               BB */{      1000,      500,    75000,     500 },
/*               DS */{      2000,      500,   110000,    2000 },
/*               BC */{       700,      400,    70000,     750 },
/*               EM */{    200000,    50000,  9000000, 1000000 },
/*               LM */{        80,       20,     2000,       0 },
/*               Ll */{       100,       25,     2000,       0 },
/*               LL */{       250,      100,     8000,       0 },
/*               AI */{       150,      500,     8000,       0 },
/*               CG */{      1100,      200,    35000,       0 },
/*               LP */{      3000,      300,   100000,       0 },
/*               PB */{         0,     2000,    20000,       0 },
/*               GB */{         0,    10000,   100000,       0 }
        };
        #endregion

        private ResultatDeCombat Resultat ;

        private struct Unite
        {
            public TypeDUnite type ;
            public uint bouclier ;
            public uint bouclierInitial ;
            public uint coque ;
            public uint coqueInitiale ;
            public uint degats ;
            public bool detruit ;
        }

        private void AffecteLesTypesDUnitesAttaquant( ref Unite[] unites, Flotte flotte )
        {
            int i = 0 ;
            for ( int j = 0 ; j < flotte.PetitsTransporteurs ; ++j )
            {
                unites[i].type = TypeDUnite.PetitTransporteur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.GrandTransporteurs ; ++j )
            {
                unites[i].type = TypeDUnite.GrandTransporteur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.ChasseursLegers ; ++j )
            {
                unites[i].type = TypeDUnite.ChasseurLeger ; ++i ;
            }
            for ( int j = 0 ; j < flotte.ChasseursLourds ; ++j )
            {
                unites[i].type = TypeDUnite.ChasseurLourd ; ++i ;
            }
            for ( int j = 0 ; j < flotte.Croiseurs ; ++j )
            {
                unites[i].type = TypeDUnite.Croiseur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.VaisseauxDeBataille ; ++j )
            {
                unites[i].type = TypeDUnite.VaisseauDeBataille ; ++i ;
            }
            for ( int j = 0 ; j < flotte.VaisseauxDeColonisation ; ++j )
            {
                unites[i].type = TypeDUnite.VaisseauDeColonisation ; ++i ;
            }
            for ( int j = 0 ; j < flotte.Recycleurs ; ++j )
            {
                unites[i].type = TypeDUnite.Recycleur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.SondesDEspionnage ; ++j )
            {
                unites[i].type = TypeDUnite.Sonde ; ++i ;
            }
            //for ( int j = 0 ; j < flotte.SatellitesSolaires ; ++j )
            //{
            //    unites[i].type = TypeDUnite.SatelliteSolaire ; ++i ;
            //}
            for ( int j = 0 ; j < flotte.Bombardiers ; ++j )
            {
                unites[i].type = TypeDUnite.Bombardier ; ++i ;
            }
            for ( int j = 0 ; j < flotte.Destructeurs ; ++j )
            {
                unites[i].type = TypeDUnite.Destructeur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.EtoilesDeLaMort ; ++j )
            {
                unites[i].type = TypeDUnite.EtoileDeLaMort ; ++i ;
            }
            for ( int j = 0 ; j < flotte.Battlecruiser ; ++j )
            {
                unites[i].type = TypeDUnite.Battlecruiser ; ++i ;
            }
        }

        private void AffecteLesTypesDUnitesDefenseur( ref Unite[] unites, Flotte flotte, Defense defenses )
        {
            int i = 0 ;
            for ( int j = 0 ; j < flotte.PetitsTransporteurs ; ++j )
            {
                unites[i].type = TypeDUnite.PetitTransporteur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.GrandTransporteurs ; ++j )
            {
                unites[i].type = TypeDUnite.GrandTransporteur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.ChasseursLegers ; ++j )
            {
                unites[i].type = TypeDUnite.ChasseurLeger ; ++i ;
            }
            for ( int j = 0 ; j < flotte.ChasseursLourds ; ++j )
            {
                unites[i].type = TypeDUnite.ChasseurLourd ; ++i ;
            }
            for ( int j = 0 ; j < flotte.Croiseurs ; ++j )
            {
                unites[i].type = TypeDUnite.Croiseur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.VaisseauxDeBataille ; ++j )
            {
                unites[i].type = TypeDUnite.VaisseauDeBataille ; ++i ;
            }
            for ( int j = 0 ; j < flotte.VaisseauxDeColonisation ; ++j )
            {
                unites[i].type = TypeDUnite.VaisseauDeColonisation ; ++i ;
            }
            for ( int j = 0 ; j < flotte.Recycleurs ; ++j )
            {
                unites[i].type = TypeDUnite.Recycleur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.SondesDEspionnage ; ++j )
            {
                unites[i].type = TypeDUnite.Sonde ; ++i ;
            }
            for ( int j = 0 ; j < flotte.SatellitesSolaires ; ++j )
            {
                unites[i].type = TypeDUnite.SatelliteSolaire ; ++i ;
            }
            for ( int j = 0 ; j < flotte.Bombardiers ; ++j )
            {
                unites[i].type = TypeDUnite.Bombardier ; ++i ;
            }
            for ( int j = 0 ; j < flotte.Destructeurs ; ++j )
            {
                unites[i].type = TypeDUnite.Destructeur ; ++i ;
            }
            for ( int j = 0 ; j < flotte.EtoilesDeLaMort ; ++j )
            {
                unites[i].type = TypeDUnite.EtoileDeLaMort ; ++i ;
            }
            for ( int j = 0 ; j < flotte.Battlecruiser ; ++j )
            {
                unites[i].type = TypeDUnite.Battlecruiser ; ++i ;
            }
            for ( int j = 0 ; j < defenses.LanceursDeMissiles ; ++j )
            {
                unites[i].type = TypeDUnite.LanceurDeMissiles ; ++i ;
            }
            for ( int j = 0 ; j < defenses.ArtilleriesLaserLegeres ; ++j )
            {
                unites[i].type = TypeDUnite.ArtillerieLaserLegere ; ++i ;
            }
            for ( int j = 0 ; j < defenses.ArtilleriesLaserLourdes ; ++j )
            {
                unites[i].type = TypeDUnite.ArtillerieLaserLourde ; ++i ;
            }
            for ( int j = 0 ; j < defenses.ArtilleriesAIons ; ++j )
            {
                unites[i].type = TypeDUnite.ArtillerieAIons ; ++i ;
            }
            for ( int j = 0 ; j < defenses.CanonsDeGauss ; ++j )
            {
                unites[i].type = TypeDUnite.CanonDeGauss ; ++i ;
            }
            for ( int j = 0 ; j < defenses.LanceursDePlasma ; ++j )
            {
                unites[i].type = TypeDUnite.LanceurDePlasma ; ++i ;
            }
            for ( int j = 0 ; j < defenses.PetitBouclier ; ++j )
            {
                unites[i].type = TypeDUnite.PetitBouclier ; ++i ;
            }
            for ( int j = 0 ; j < defenses.GrandBouclier ; ++j )
            {
                unites[i].type = TypeDUnite.GrandBouclier ; ++i ;
            }
        }

        private void InitialiseLesUnites( ref Unite[] unites, Technologie niveaux )
        {
            for ( int i = 0 ; i < unites.Length ; ++i )
            {
                // Valeurs en fonction du type d'unité
                unites[i].bouclierInitial = tableDesCaracteristiques[ (int)unites[i].type, (int)TypeDeCaracteristique.Bouclier ] ;
                unites[i].coqueInitiale   = tableDesCaracteristiques[ (int)unites[i].type, (int)TypeDeCaracteristique.Coque    ] ;
                unites[i].degats          = tableDesCaracteristiques[ (int)unites[i].type, (int)TypeDeCaracteristique.Degats   ] ;
                // Ajustement des niveaux technologiques
                unites[i].bouclierInitial = unites[i].bouclierInitial * (100+10*niveaux.Bouclier                      ) / 100  ;
                unites[i].coqueInitiale   = unites[i].coqueInitiale   * (100+10*niveaux.ProtectionDesVaisseauxSpatiaux) / 1000 ;
                unites[i].degats          = unites[i].degats          * (100+10*niveaux.Armes                         ) / 100  ;
                // Initialisation de la coque
                unites[i].coque = unites[i].coqueInitiale  ;
            }
        }

        private void ReinitialiseLeBouclier( ref Unite[] unites )
        {
            for ( int i = 0 ; i < unites.Length ; ++i )
            {
                unites[i].bouclier = unites[i].bouclierInitial ;
            }
        }

        private uint ClasserEtCompterLesUnitesEncoreValides( ref Unite[] unites )
        {
            Unite[] unitesValides = new Unite[ unites.Length ] ;
            uint compteDesNonDetruits = 0 ;
            uint pos = 0 ; // Position dans le nouveau tableau (trié)
            // Unites non détruites
            for ( uint p = 0 ; p < unites.Length ; ++p ) 
            {
                if ( !unites[p].detruit )
                {
                    unitesValides[pos] = unites[p] ;
                    ++pos ;
                }
            }
            compteDesNonDetruits = pos ;
            // Unites détruites
            for ( uint p = 0 ; p < unites.Length ; ++p ) 
            {
                if ( unites[p].detruit )
                {
                    unitesValides[pos] = unites[p] ;
                    ++pos ;
                }
            }
            // Recopie dans le tableau initial
            for ( uint p = 0 ; p < unites.Length ; ++p ) 
            {
                unites[p] = unitesValides[p] ;
            }
            return compteDesNonDetruits ;
        }

        private void termineLeCombat( ref Unite[] UnitesAttaquant , ref Unite[] UnitesDefenseur )
        {
            #region Remise à 0 de tous les comptes
            Attaquant.FlotteAQuai.Bombardiers             = 0 ;
            Attaquant.FlotteAQuai.ChasseursLegers         = 0 ;
            Attaquant.FlotteAQuai.ChasseursLourds         = 0 ;
            Attaquant.FlotteAQuai.Croiseurs               = 0 ;
            Attaquant.FlotteAQuai.Destructeurs            = 0 ;
            Attaquant.FlotteAQuai.Battlecruiser           = 0 ;
            Attaquant.FlotteAQuai.EtoilesDeLaMort         = 0 ;
            Attaquant.FlotteAQuai.GrandTransporteurs      = 0 ;
            Attaquant.FlotteAQuai.PetitsTransporteurs     = 0 ;
            Attaquant.FlotteAQuai.Recycleurs              = 0 ;
            Attaquant.FlotteAQuai.SatellitesSolaires      = 0 ;
            Attaquant.FlotteAQuai.SondesDEspionnage       = 0 ;
            Attaquant.FlotteAQuai.VaisseauxDeBataille     = 0 ;
            Attaquant.FlotteAQuai.VaisseauxDeColonisation = 0 ;
                                                                                                         
            Defenseur.FlotteAQuai.Bombardiers             = 0 ;
            Defenseur.FlotteAQuai.ChasseursLegers         = 0 ;
            Defenseur.FlotteAQuai.ChasseursLourds         = 0 ;
            Defenseur.FlotteAQuai.Croiseurs               = 0 ;
            Defenseur.FlotteAQuai.Destructeurs            = 0 ;
            Defenseur.FlotteAQuai.Battlecruiser           = 0 ;
            Defenseur.FlotteAQuai.EtoilesDeLaMort         = 0 ;
            Defenseur.FlotteAQuai.GrandTransporteurs      = 0 ;
            Defenseur.FlotteAQuai.PetitsTransporteurs     = 0 ;
            Defenseur.FlotteAQuai.Recycleurs              = 0 ;
            Defenseur.FlotteAQuai.SatellitesSolaires      = 0 ;
            Defenseur.FlotteAQuai.SondesDEspionnage       = 0 ;
            Defenseur.FlotteAQuai.VaisseauxDeBataille     = 0 ;
            Defenseur.FlotteAQuai.VaisseauxDeColonisation = 0 ;

            Defenseur.Defenses.ArtilleriesAIons        = 0 ;
            Defenseur.Defenses.ArtilleriesLaserLegeres = 0 ;
            Defenseur.Defenses.ArtilleriesLaserLourdes = 0 ;
            Defenseur.Defenses.CanonsDeGauss           = 0 ;
            Defenseur.Defenses.GrandBouclier           = 0 ;
            Defenseur.Defenses.LanceursDeMissiles      = 0 ;
            Defenseur.Defenses.LanceursDePlasma        = 0 ;
            Defenseur.Defenses.PetitBouclier           = 0 ;
            #endregion
            
            foreach ( Unite u in UnitesAttaquant )
            {
                if ( !u.detruit )
                {
                    switch ( u.type )
                    {
                        case TypeDUnite.PetitTransporteur      : Attaquant.FlotteAQuai.PetitsTransporteurs     += 1 ; break ;
                        case TypeDUnite.GrandTransporteur      : Attaquant.FlotteAQuai.GrandTransporteurs      += 1 ; break ;
                        case TypeDUnite.ChasseurLeger          : Attaquant.FlotteAQuai.ChasseursLegers         += 1 ; break ;
                        case TypeDUnite.ChasseurLourd          : Attaquant.FlotteAQuai.ChasseursLourds         += 1 ; break ;
                        case TypeDUnite.Croiseur               : Attaquant.FlotteAQuai.Croiseurs               += 1 ; break ;
                        case TypeDUnite.VaisseauDeBataille     : Attaquant.FlotteAQuai.VaisseauxDeBataille     += 1 ; break ;
                        case TypeDUnite.VaisseauDeColonisation : Attaquant.FlotteAQuai.VaisseauxDeColonisation += 1 ; break ;
                        case TypeDUnite.Recycleur              : Attaquant.FlotteAQuai.Recycleurs              += 1 ; break ;
                        case TypeDUnite.Sonde                  : Attaquant.FlotteAQuai.SondesDEspionnage       += 1 ; break ;
                        case TypeDUnite.SatelliteSolaire       : Attaquant.FlotteAQuai.SatellitesSolaires      += 1 ; break ;
                        case TypeDUnite.Bombardier             : Attaquant.FlotteAQuai.Bombardiers             += 1 ; break ;
                        case TypeDUnite.Destructeur            : Attaquant.FlotteAQuai.Destructeurs            += 1 ; break ;
                        case TypeDUnite.Battlecruiser          : Attaquant.FlotteAQuai.Battlecruiser           += 1 ; break ;
                        case TypeDUnite.EtoileDeLaMort         : Attaquant.FlotteAQuai.EtoilesDeLaMort         += 1 ; break ;
                    }
                }   
            }
            foreach ( Unite u in UnitesDefenseur )
            {
                if ( !u.detruit )
                {
                    switch ( u.type )
                    {
                        case TypeDUnite.PetitTransporteur      : Defenseur.FlotteAQuai.PetitsTransporteurs     += 1 ; break ;
                        case TypeDUnite.GrandTransporteur      : Defenseur.FlotteAQuai.GrandTransporteurs      += 1 ; break ;
                        case TypeDUnite.ChasseurLeger          : Defenseur.FlotteAQuai.ChasseursLegers         += 1 ; break ;
                        case TypeDUnite.ChasseurLourd          : Defenseur.FlotteAQuai.ChasseursLourds         += 1 ; break ;
                        case TypeDUnite.Croiseur               : Defenseur.FlotteAQuai.Croiseurs               += 1 ; break ;
                        case TypeDUnite.VaisseauDeBataille     : Defenseur.FlotteAQuai.VaisseauxDeBataille     += 1 ; break ;
                        case TypeDUnite.VaisseauDeColonisation : Defenseur.FlotteAQuai.VaisseauxDeColonisation += 1 ; break ;
                        case TypeDUnite.Recycleur              : Defenseur.FlotteAQuai.Recycleurs              += 1 ; break ;
                        case TypeDUnite.Sonde                  : Defenseur.FlotteAQuai.SondesDEspionnage       += 1 ; break ;
                        case TypeDUnite.SatelliteSolaire       : Defenseur.FlotteAQuai.SatellitesSolaires      += 1 ; break ;
                        case TypeDUnite.Bombardier             : Defenseur.FlotteAQuai.Bombardiers             += 1 ; break ;
                        case TypeDUnite.Destructeur            : Defenseur.FlotteAQuai.Destructeurs            += 1 ; break ;
                        case TypeDUnite.Battlecruiser          : Defenseur.FlotteAQuai.Battlecruiser           += 1 ; break ;
                        case TypeDUnite.EtoileDeLaMort         : Defenseur.FlotteAQuai.EtoilesDeLaMort         += 1 ; break ;
                        case TypeDUnite.LanceurDeMissiles      : Defenseur.Defenses.LanceursDeMissiles         += 1 ; break ;
                        case TypeDUnite.ArtillerieLaserLegere  : Defenseur.Defenses.ArtilleriesLaserLegeres    += 1 ; break ;
                        case TypeDUnite.ArtillerieLaserLourde  : Defenseur.Defenses.ArtilleriesLaserLourdes    += 1 ; break ;
                        case TypeDUnite.ArtillerieAIons        : Defenseur.Defenses.ArtilleriesAIons           += 1 ; break ;
                        case TypeDUnite.CanonDeGauss           : Defenseur.Defenses.CanonsDeGauss              += 1 ; break ;
                        case TypeDUnite.LanceurDePlasma        : Defenseur.Defenses.LanceursDePlasma           += 1 ; break ;
                        case TypeDUnite.PetitBouclier          : Defenseur.Defenses.PetitBouclier              += 1 ; break ;
                        case TypeDUnite.GrandBouclier          : Defenseur.Defenses.GrandBouclier              += 1 ; break ;
                    }
                }
            }
        }


        public ResultatDeCombat Simuler()
        {
            //log.Debug("% de vitesse = " + Attaquant.FlotteAQuai.RatioVitesseFlotte ) ;
            Resultat = new ResultatDeCombat() ;
            
            uint NombreDUniteAttaquantValides = Attaquant.FlotteAQuai.Nombre ;
            uint NombreDUniteDefenseurValides = Defenseur.FlotteAQuai.Nombre + Defenseur.Defenses.Nombre ;
            Unite[] unitesAttaquant = new Unite[ NombreDUniteAttaquantValides ] ;
            Unite[] unitesDefenseur = new Unite[ NombreDUniteDefenseurValides ] ;

            AffecteLesTypesDUnitesAttaquant( ref unitesAttaquant, Attaquant.FlotteAQuai ) ;
            AffecteLesTypesDUnitesDefenseur( ref unitesDefenseur, Defenseur.FlotteAQuai, Defenseur.Defenses ) ;

            InitialiseLesUnites( ref unitesAttaquant, Attaquant.Recherches ) ;
            InitialiseLesUnites( ref unitesDefenseur, Defenseur.Recherches ) ;

            uint NombreDeTours ;
            for ( NombreDeTours = 1 ; NombreDeTours <= 6 ; ++NombreDeTours )
            {
                if ( NombreDUniteAttaquantValides == 0 ) break ;
                if ( NombreDUniteDefenseurValides == 0 ) break ;

                ReinitialiseLeBouclier( ref unitesAttaquant ) ;
                ReinitialiseLeBouclier( ref unitesDefenseur ) ;

                #region Fait taper tout le monde
                //TODO: Garder les stats
                #region Attaquant tape
                //log.Debug( "L'attaquant tape..." ) ;
                for ( int i = 0 ; i < NombreDUniteAttaquantValides ; ++i )
                {
                    do
                    {
                        int idUniteDefense = r.Next((int)NombreDUniteDefenseurValides) ;
                        
                        //log.Debug( "  Un " + UniteToString(u) + " tape un " + UniteToString(unitesDefenseur[idUniteDefense]) + ".") ;
                        
                        uint DegatsRestantAInfliger = unitesAttaquant[i].degats ;
                        // Calcul de l'absorbtion du bouclier
                        if ( DegatsRestantAInfliger < unitesDefenseur[idUniteDefense].bouclierInitial / 100 )
                        {
                            //log.Debug( "    L'attaque n'est pas assez puissante pour avoir un effet." ) ;
                            DegatsRestantAInfliger = 0 ;
                        }
                        else
                        {
                            if ( DegatsRestantAInfliger < unitesDefenseur[idUniteDefense].bouclier )
                            {
                                //log.Debug( "    Le bouclier de l'unité en défense a tout absorbé." ) ;
                                unitesDefenseur[idUniteDefense].bouclier -= DegatsRestantAInfliger ;
                                DegatsRestantAInfliger = 0 ;
                            }
                            else
                            {
                                //log.Debug( "    Le bouclier de l'unité en défense a absorbé " + unitesDefenseur[idUniteDefense].bouclier + " points." ) ;
                                DegatsRestantAInfliger -= unitesDefenseur[idUniteDefense].bouclier ;
                                unitesDefenseur[idUniteDefense].bouclier = 0 ;
                            }
                        }
                        // Calcul des dégats dans la coque
                        if ( DegatsRestantAInfliger > 0 )
                        {
                            //log.Debug( "    L'unité en défense encaisse " + DegatsRestantAInfliger + " points." ) ;
                            if ( DegatsRestantAInfliger < unitesDefenseur[idUniteDefense].coque )
                            {
                                unitesDefenseur[idUniteDefense].coque -= DegatsRestantAInfliger ;
                            }
                            else
                            {
                                //log.Debug( "    L'unité en défense a été détruite (reste 0 points de structure)." ) ;
                                unitesDefenseur[idUniteDefense].coque = 0 ;
                                unitesDefenseur[idUniteDefense].detruit = true ;
                            }
                        }
                        // Calcul de la probabilité de destruction
                        if ( unitesDefenseur[idUniteDefense].coque * 10 < unitesDefenseur[idUniteDefense].coqueInitiale * 7 )
                        {
                            if ( (uint)r.Next((int)unitesDefenseur[idUniteDefense].coqueInitiale) > unitesDefenseur[idUniteDefense].coque )
                            {
                                //log.Debug( "    L'unité en défense a été détruite (reste " + unitesDefenseur[idUniteDefense].coque + " points de structure)." ) ;
                                unitesDefenseur[idUniteDefense].detruit = true ;
                            }
                            else
                            {
                                //log.Debug( "    L'unité en défense a résisté (reste " + unitesDefenseur[idUniteDefense].coque + " points de structure)." ) ;
                            }
                        }
                        else
                        {
                            //log.Debug( "    L'unité en défense a résisté (reste " + unitesDefenseur[idUniteDefense].coque + " points de structure)." ) ;
                        }
                        // Calcul de la probabilité de rapidfire
                        if ( (r.NextDouble()*100) > TableDesRapidFire[ (int)unitesAttaquant[i].type, (int)unitesDefenseur[idUniteDefense].type ] )
                        {
                            break ;
                        }
                    } while ( true ) ;
                }
                #endregion
                #region Defenseur tape
                //log.Debug( "Le défenseur tape..." ) ;
                for ( int i = 0 ; i < NombreDUniteDefenseurValides ; ++i )
                {
                    do
                    {
                        int idUniteAttaque = r.Next((int)NombreDUniteAttaquantValides) ;

                        //log.Debug( "  Un " + UniteToString(u) + " tape un " + UniteToString(uniteEnAttaque) + ".") ;

                        uint DegatsRestantAInfliger = unitesDefenseur[i].degats ;
                        // Calcul de l'absorbtion du bouclier
                        if ( DegatsRestantAInfliger < unitesAttaquant[idUniteAttaque].bouclierInitial / 100 )
                        {
                            //log.Debug( "    L'attaque n'est pas assez puissante pour avoir un effet." ) ;
                            DegatsRestantAInfliger = 0 ;
                        }
                        else
                        {
                            if ( DegatsRestantAInfliger < unitesAttaquant[idUniteAttaque].bouclier )
                            {
                                //log.Debug( "    Le bouclier de l'unité en attaque a tout absorbé." ) ;
                                unitesAttaquant[idUniteAttaque].bouclier -= DegatsRestantAInfliger ;
                                DegatsRestantAInfliger = 0 ;
                            }
                            else
                            {
                                //log.Debug( "    Le bouclier de l'unité en attaque a absorbé " + unitesAttaquant[idUniteAttaque].bouclier + " points." ) ;
                                DegatsRestantAInfliger -= unitesAttaquant[idUniteAttaque].bouclier ;
                                unitesAttaquant[idUniteAttaque].bouclier = 0 ;
                            }
                        }
                        // Calcul des dégats dans la coque
                        if ( DegatsRestantAInfliger > 0 )
                        {
                            //log.Debug( "    L'unité en attaque encaisse " + DegatsRestantAInfliger + " points." ) ;
                            if ( DegatsRestantAInfliger < unitesAttaquant[idUniteAttaque].coque )
                            {
                                unitesAttaquant[idUniteAttaque].coque -= DegatsRestantAInfliger ;
                            }
                            else
                            {
                                //log.Debug( "    L'unité en attaque a été détruite (reste 0 points de structure)." ) ;
                                unitesAttaquant[idUniteAttaque].coque = 0 ;
                                unitesAttaquant[idUniteAttaque].detruit = true ;
                            }
                        }
                        // Calcul de la probabilité de destruction
                        if ( unitesAttaquant[idUniteAttaque].coque * 10 < unitesAttaquant[idUniteAttaque].coqueInitiale * 7 )
                        {
                            if ( (uint)r.Next((int)unitesAttaquant[idUniteAttaque].coqueInitiale) > unitesAttaquant[idUniteAttaque].coque )
                            {
                                //log.Debug( "    L'unité en attaque a été détruite (reste " + unitesAttaquant[idUniteAttaque].coque + " points de structure)." ) ;
                                unitesAttaquant[idUniteAttaque].detruit = true ;
                            }
                            else
                            {
                                //log.Debug( "    L'unité en attaque a résisté (reste " + unitesAttaquant[idUniteAttaque].coque + " points de structure)." ) ;
                            }
                        }
                        else
                        {
                            //log.Debug( "    L'unité en attaque a résisté (reste " + unitesAttaquant[idUniteAttaque].coque + " points de structure)." ) ;
                        }
                        // Calcul de la probabilité de rapidfire
                        if ( (r.NextDouble()*100) > TableDesRapidFire[ (int)unitesDefenseur[i].type, (int)unitesAttaquant[idUniteAttaque].type ] )
                        {
                            break ;
                        }
                    } while ( true ) ;
                }
                #endregion
                #endregion

                NombreDUniteAttaquantValides = ClasserEtCompterLesUnitesEncoreValides( ref unitesAttaquant ) ;
                NombreDUniteDefenseurValides = ClasserEtCompterLesUnitesEncoreValides( ref unitesDefenseur ) ;

                if ( NombreDUniteAttaquantValides == 0 ) break ;
                if ( NombreDUniteDefenseurValides == 0 ) break ;
            }

            Resultat.Pillage = new Ressources() ;

            Resultat.Consommation = _AttaquantInitial.FlotteAQuai.Consommation( _DefenseurInitial.Coordonnees, 100 ) ;
            Resultat.TempsDeTrajet = _AttaquantInitial.FlotteAQuai.TempsDeTrajet( _DefenseurInitial.Coordonnees ) ;

            if ( NombreDeTours > 6 ) NombreDeTours = 6 ;
            termineLeCombat( ref unitesAttaquant, ref unitesDefenseur ) ;

            Resultat.Ruines = 
                (_DefenseurInitial.FlotteAQuai - Defenseur.FlotteAQuai).ValeurEnRuines() +
                (_AttaquantInitial.FlotteAQuai - Attaquant.FlotteAQuai).ValeurEnRuines() ;

            Resultat.PertesAttaquant =
                (_AttaquantInitial.FlotteAQuai - Attaquant.FlotteAQuai).ValeurDAchat() ;

            Resultat.PertesDefenseur =
                (_DefenseurInitial.Defenses    - Defenseur.Defenses   ).ValeurDAchat() +
                (_DefenseurInitial.FlotteAQuai - Defenseur.FlotteAQuai).ValeurDAchat() ;

            Resultat.NombreDeTours = (int)NombreDeTours ;
            if ( NombreDUniteAttaquantValides == 0 )
            {
                Resultat.Vainqueur = VainqueurDeCombat.Defenseur ;
            }
            else if ( NombreDUniteDefenseurValides == 0 )
            {
                Resultat.Vainqueur = VainqueurDeCombat.Attaquant ;
            }
            else
            {
                Resultat.Vainqueur = VainqueurDeCombat.Nul ;
            }

            if ( Resultat.Vainqueur == VainqueurDeCombat.Attaquant )
            {
                Resultat.Pillage =
                    CalculeLePillage( _DefenseurInitial.Ressources, Attaquant.FlotteAQuai ) ;
            }
            else
            {
                Resultat.Pillage = new Ressources() ;
            }

            Resultat.GainAttaquantAvecRecyclage = (RessourcesLong)Resultat.Pillage - Resultat.PertesAttaquant  ;
            Resultat.GainAttaquantSansRecyclage = Resultat.GainAttaquantSansRecyclage + Resultat.Ruines ;
            Resultat.RentabiliteAttaquantSansRecyclage = (RessourcesLong)Resultat.Pillage - Resultat.PertesAttaquant - Resultat.Consommation ;
            Resultat.RentabiliteAttaquantAvecRecyclage = Resultat.RentabiliteAttaquantSansRecyclage + Resultat.Ruines ;
            Resultat.RentabiliteDefenseurSansRecyclage = -(RessourcesLong)Resultat.Pillage - Resultat.PertesDefenseur ;
            Resultat.RentabiliteDefenseurAvecRecyclage = Resultat.RentabiliteDefenseurSansRecyclage + Resultat.Ruines ;
            
            return Resultat ;
        }

        public StatistiquesDeSimulation Simuler( int nombreDeSimulations )
        {
            StatistiquesDeSimulation stats = new StatistiquesDeSimulation() ;
            for ( int i = 0 ; i < nombreDeSimulations ; ++i )
            {
                _Attaquant = new RapportDEspionnage(_AttaquantInitial) ;
                _Defenseur = new RapportDEspionnage(_DefenseurInitial) ;
                ResultatDeCombat res = Simuler() ;
                stats.AjouteUnResultat( res ) ;
            }
            return stats ;
        }

        private Ressources CalculeLePillage(Ressources ressources, Flotte flotte)
        {
            uint capacite = flotte.CapaciteDeTransport ;
            uint capaciteRestante = capacite ;
            // 1/ On elimine du calcul la moitié du metal, cristal & deuterium de la planète
            Ressources pillable = ressources/2 ;
            Ressources r = new Ressources() ;
            // 2/ On remplit le tiers de la capacité de fret des vaisseaux avec tout le metal disponible.
            r.Metal = Math.Min( pillable.Metal, capacite/3 ) ;
            pillable.Metal -= r.Metal ;
            capaciteRestante -= r.Metal ;
            // 3/ Ensuite, on remplie la moitié de la capacité restante avec le plus de cristal disponible.
            r.Cristal = Math.Min( pillable.Cristal, capacite/2 ) ;
            pillable.Cristal -= r.Cristal ;
            capaciteRestante -= r.Cristal ;
            // 4/ Enfin, on bourre le deut dans ce qui reste.
            r.Deuterium = Math.Min( pillable.Deuterium, capacite ) ;
            pillable.Deuterium -= r.Deuterium ;
            capaciteRestante -= r.Deuterium ;
            // 5/ On remplit la moitié de la capacité disponible avec le metal
            uint metalPilleTour2 = Math.Min( pillable.Metal, capaciteRestante/2 ) ;
            r.Metal += metalPilleTour2 ;
            capaciteRestante -= metalPilleTour2 ;
            // 6/ on prend tout le cristal restant, dans la limite de la capacité biensur.
            uint crisPilleTour2 = Math.Min( pillable.Cristal, capaciteRestante ) ;
            r.Cristal += crisPilleTour2 ;
            capaciteRestante -= crisPilleTour2 ;
            // fin
            return r ;
        }
    }

    public class InterfaceServeur
    {
        public delegate void InterfaceServeurEvent( object sender, EventArgs e ) ;

        public event InterfaceServeurEvent onConnect ;

        private String _URL ;
        public String URL
        {
            get{
                return _URL ;
            }
            set{
                if ( _URL != value )
                {
                    Deconnecte() ;
                }
                _URL = value ;
            }
        }
        private String _Login ;
        public String Login
        {
            get{
                return _Login ;
            }
            set{
                if ( _Login != value )
                {
                    Deconnecte() ;
                }
               _Login = value ;
            }
        }
        private String _MotDePasse ;
        public String MotDePasse
        {
            get{
                return _MotDePasse ;
            }
            set{
                if ( _MotDePasse != value )
                {
                    Deconnecte() ;
                }
                _MotDePasse = value ;
            }
        }

        private int recupereValeur( String donnees, String cle )
        {
            Regex r = new Regex( cle + @"=(\d+)", RegexOptions.IgnoreCase );
            Match m = r.Match( donnees );
            if ( m.Success )
            {
                return System.Convert.ToInt32(m.Groups[1].Value) ;
            }
            return 0 ;
        }

        private void initialiseInterfaceServeur()
        {
            _URL = "" ;
            _Login = "" ;
            _MotDePasse = "" ;
            AuthString = "" ;
            _canExportReports = false ;
            _canExportPlanets = false ;
            _canImportReports = false ;
            _canImportPlanets = false ;
        }

        public InterfaceServeur()
        {
            initialiseInterfaceServeur() ;
        }
        public InterfaceServeur( String URL, String Login, String MotDePasse )
        {
            initialiseInterfaceServeur() ;
            this.URL = URL ;
            this.Login = Login ;
            this.MotDePasse = MotDePasse ;
        }

        public bool EstConnecte
        {
            get {
                //return _EstConnecte ;
                return AuthString != "" ;
            }
        }        

        private String _AuthString ;
        private String AuthString
        {
            get {
                return _AuthString ;
            }
            set {
                bool connecte   = (_AuthString=="" && value!="") ;
                bool deconnecte = (_AuthString!="" && value=="") ;
                _AuthString = value ;
                if ( connecte ) onConnect(this, null) ;
                //if ( deconnecte ) onDeconnection(this, null) ;
            }
        }

        private bool _canExportReports ;
        public bool canExportReports { get { return _canExportReports ; } }
        private bool _canExportPlanets ;
        public bool canExportPlanets { get { return _canExportPlanets ; } }
        private bool _canImportReports ;
        public bool canImportReports { get { return _canImportReports ; } }
        private bool _canImportPlanets ;
        public bool canImportPlanets { get { return _canImportPlanets ; } }

        public bool Connecte()
        {
            if ( EstConnecte )
            {
                Deconnecte() ;
            }
            if ( Login == "" ) return false ;
            if ( MotDePasse == "" ) return false ;
            if ( URL == "" ) return false ;
            try
            {
                System.Net.HttpWebRequest requeteHTTP = (System.Net.WebRequest.Create( URL +"index.php?action=login&name="+Login+"&ogsversion=061028" ) as System.Net.HttpWebRequest) ;
                if ( requeteHTTP == null ) return false ;
                requeteHTTP.KeepAlive = false ;
                requeteHTTP.ContentType = "application/x-www-form-urlencoded" ;
                requeteHTTP.UserAgent = "OGSClient 2.0.2492.1222 (061028)" ;
                requeteHTTP.ContentLength = MotDePasse.Length + 5 ;
                requeteHTTP.Method = "POST" ;
                String data = "pass="+MotDePasse ;
                Stream s = requeteHTTP.GetRequestStream() ;
                StreamWriter sw = new StreamWriter(s) ;
                sw.Write(data) ;
                sw.Close() ;
                System.Net.HttpWebResponse reponse = (requeteHTTP.GetResponse() as System.Net.HttpWebResponse) ;
                if ( reponse == null ) return false ;
                Stream r = reponse.GetResponseStream() ;
                StreamReader sr = new StreamReader(r) ;
                data = sr.ReadToEnd() ;
                sr.Close() ;
                if ( data.Contains("ErrorFatal") )
                {
                    return false ;
                }
                String authCookie = reponse.Headers.Get("Set-Cookie") ;
                if ( authCookie.Contains("ogspy_id=") )
                {
                    _canExportReports = data.Contains(@"[ExportSpyAuth=1]") ;
                    _canExportPlanets = data.Contains(@"[ExportSysAuth=1]") ;
                    _canImportReports = data.Contains(@"[ImportSpyAuth=1]") ;
                    _canImportPlanets = data.Contains(@"[ImportSysAuth=1]") ;
                    AuthString = authCookie.Substring(9) ;
                    return true ;
                }
                return false ;
            }
            catch ( Exception )
            {
                AuthString = "" ;
                return false ;
            }
        }

        public bool Connecte(String login, String motDePasse)
        {
            this.Login = login ;
            this.MotDePasse = motDePasse ;
            return Connecte() ;
        }

        public void Deconnecte()
        {
            _canExportReports = false ;
            _canExportPlanets = false ;
            _canImportReports = false ;
            _canImportPlanets = false ;
            if ( EstConnecte )
            {
                AuthString = "" ;
            }
        }

        // Fonctions d'import

        public Collection<RapportDEspionnage> ImporterLesRapportsDepuis(DateTime date)
        {
            if ( !EstConnecte )
            {
                throw new Exception("Impossible d'importer une galaxie : non connecté au serveur.") ;
            }
            Collection<RapportDEspionnage> retour = new Collection<RapportDEspionnage>() ;
            System.Net.HttpWebRequest requeteHTTP = (System.Net.WebRequest.Create( URL +"index.php?action=spyreport&since="+date.ToString("yyyy-MM-dd")+" 01:01:01" ) as System.Net.HttpWebRequest) ;
            if ( requeteHTTP == null ) throw new Exception("Impossible de créer la requête HTTP !") ;
            requeteHTTP.KeepAlive = false ;
            requeteHTTP.Headers.Add("Cookie", "ogspy_id="+AuthString) ;
            requeteHTTP.ContentType = "application/x-www-form-urlencoded" ;
            requeteHTTP.UserAgent = "OGSClient 2.0.2492.1222 (061028)" ;
            requeteHTTP.ContentLength = 0 ;
            requeteHTTP.Method = "POST" ;
            System.Net.HttpWebResponse reponse = (requeteHTTP.GetResponse() as System.Net.HttpWebResponse) ;
            if ( reponse == null ) throw new Exception("Erreur de requeteHTTP.GetResponse() !") ;
            Stream r = reponse.GetResponseStream() ;
            StreamReader sr = new StreamReader(r, System.Text.Encoding.GetEncoding("Latin1")) ;
            String data ;
            data = sr.ReadToEnd() ;
            sr.Close() ;
            
            int indexContributeur =  0 ;
            int indexRapport      =  0 ;
            
            String[] separators = new String[1] ;
            separators[0] = "<->" ;
            String[] rapports = data.Split( separators, StringSplitOptions.RemoveEmptyEntries ) ;
            separators[0] = "," ;
            if ( rapports.Length > 0 )
            {
                String[] indices = rapports[0].Split( separators, StringSplitOptions.RemoveEmptyEntries ) ;
                foreach( String indice in indices )
                {
                    if ( indice.StartsWith("sendername=") )
                    {
                        indexContributeur = recupereValeur(indice, "sendername") ;
                    }
                    else if ( indice.StartsWith("report=") )
                    {
                        indexRapport = recupereValeur(indice, "report") ;
                    }
                    else
                    {
                        throw new Exception("Indice inconnu ! ("+indice+")") ;
                    }
                }
                if ( indexContributeur < 1 || indexContributeur > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                if ( indexRapport      < 1 || indexRapport      > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;

                rapports[0] = "" ;
            }
            separators[0] = "<||>" ;
            foreach( String rapportString in rapports )
            {
                if ( rapportString == "" ) continue ;
                String[] valeurs = rapportString.Split( separators, StringSplitOptions.None ) ;
                RapportDEspionnage rapport = null ;
                String contrib = "" ;
                for( int i = 0 ; i < valeurs.Length ; ++i )
                {
                    int indice = i+1 ;
                    if ( indice == indexRapport      )
                    {
                        try
                        {
                            rapport = new RapportDEspionnage( valeurs[i] ) ;
                            log.Debug( "Rapport récupéré !" ) ;
                        }
                        catch ( Exception ex )
                        {
                            log.Debug( "Echec de transformation du rapport." ) ;
                            log.Debug( "Message :" ) ;
                            log.Debug( ex.Message ) ;
                            log.Debug( "Source :" ) ;
                            log.Debug( ex.Source ) ;
                            log.Debug( "Source :" ) ;
                            log.Debug( valeurs[i] ) ;
                        }
                    }
                    else if ( indice == indexContributeur )
                    {
                        contrib = valeurs[i] ;//OSEF, j'affiche pas le contributeur pour l'instant.
                    }
                }
                if ( rapport != null )
                {
                    rapport.Contributeur = contrib ;
                    retour.Add( rapport ) ;
                }
            }
            return retour ;
        }

        public Collection<Planete> ImporteLaGalaxie(int galaxie)
        {
            if ( galaxie < 1 || galaxie > 9 )
            {
                throw new ArgumentOutOfRangeException( "galaxie", "Une Galaxie doit etre comprise entre 1 et 9 (est " + galaxie + ")" );
            }
            if ( !EstConnecte )
            {
                throw new Exception("Impossible d'importer une galaxie : non connecté au serveur.") ;
            }
            Collection<Planete> retour = new Collection<Planete>() ;
            try
            {
                System.Net.HttpWebRequest requeteHTTP = (System.Net.WebRequest.Create( URL +"index.php?action=fbimport&galnum="+galaxie+"&sincedate=2005-01-01 00:00:00" ) as System.Net.HttpWebRequest) ;
                if ( requeteHTTP == null ) throw new Exception("Impossible de créer la requête HTTP !") ;
                requeteHTTP.KeepAlive = false ;
                requeteHTTP.Headers.Add("Cookie", "ogspy_id="+AuthString) ;
                requeteHTTP.ContentType = "application/x-www-form-urlencoded" ;
                requeteHTTP.UserAgent = "OGSClient 2.0.2492.1222 (061028)" ;
                requeteHTTP.ContentLength = 0 ;
                requeteHTTP.Method = "POST" ;
                System.Net.HttpWebResponse reponse = (requeteHTTP.GetResponse() as System.Net.HttpWebResponse) ;
                if ( reponse == null ) throw new Exception("Erreur de requeteHTTP.GetResponse() !") ;
                Stream r = reponse.GetResponseStream() ;
                StreamReader sr = new StreamReader(r, System.Text.Encoding.GetEncoding("Latin1")) ;
                String data ;
                data = sr.ReadToEnd() ;
                sr.Close() ;
                
                int indexGalaxie      =  0 ;
                int indexSysteme      =  0 ;
                int indexPlanete      =  0 ;
                int indexLune         =  0 ;
                int indexNom          =  0 ;
                int indexJoueur       =  0 ;
                int indexAlliance     =  0 ;
                int indexStatus       =  0 ;
                int indexDateEtHeure  =  0 ;
                int indexContributeur =  0 ;
                
                String[] separators = new String[1] ;
                separators[0] = "<->" ;
                String[] planetes = data.Split( separators, StringSplitOptions.RemoveEmptyEntries ) ;
                separators[0] = "," ;
                if ( planetes.Length > 0 )
                {
                    String[] indices = planetes[0].Split( separators, StringSplitOptions.RemoveEmptyEntries ) ;
                    foreach( String indice in indices )
                    {
                        if ( indice.StartsWith("galaxy=") )
                        {
                            indexGalaxie = recupereValeur(indice, "galaxy") ;
                        }
                        else if ( indice.StartsWith("system=") )
                        {
                            indexSysteme = recupereValeur(indice, "system") ;
                        }
                        else if ( indice.StartsWith("row=") )
                        {
                            indexPlanete = recupereValeur(indice, "row") ;
                        }
                        else if ( indice.StartsWith("moon=") )
                        {
                            indexLune = recupereValeur(indice, "moon") ;
                        }
                        else if ( indice.StartsWith("planetname=") )
                        {
                            indexNom = recupereValeur(indice, "planetname") ;
                        }
                        else if ( indice.StartsWith("playername=") )
                        {
                            indexJoueur = recupereValeur(indice, "playername") ;
                        }
                        else if ( indice.StartsWith("allytag=") )
                        {
                            indexAlliance = recupereValeur(indice, "allytag") ;
                        }
                        else if ( indice.StartsWith("status=") )
                        {
                            indexStatus = recupereValeur(indice, "status") ;
                        }
                        else if ( indice.StartsWith("datetime=") )
                        {
                            indexDateEtHeure = recupereValeur(indice, "datetime") ;
                        }
                        else if ( indice.StartsWith("sendername=") )
                        {
                            indexContributeur = recupereValeur(indice, "sendername") ;
                        }
                        else
                        {
                            throw new Exception("Indice inconnu ! ("+indice+")") ;
                        }
                    }
                    if ( indexGalaxie      < 1 || indexGalaxie      > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                    if ( indexSysteme      < 1 || indexSysteme      > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                    if ( indexPlanete      < 1 || indexPlanete      > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                    if ( indexLune         < 1 || indexLune         > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                    if ( indexNom          < 1 || indexNom          > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                    if ( indexJoueur       < 1 || indexJoueur       > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                    if ( indexAlliance     < 1 || indexAlliance     > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                    if ( indexStatus       < 1 || indexStatus       > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                    if ( indexDateEtHeure  < 1 || indexDateEtHeure  > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;
                    if ( indexContributeur < 1 || indexContributeur > indices.Length ) throw new Exception("Lecture des indices incorrecte !") ;

                    planetes[0] = "" ;
                }
                separators[0] = "<||>" ;
                foreach( String planeteString in planetes )
                {
                    if ( planeteString == "" ) continue ;
                    String[] valeurs = planeteString.Split( separators, StringSplitOptions.None ) ;
                    Planete planete = new Planete() ;
                    UInt16 g = 0 ; // Coordonnee g de la planete
                    UInt16 s = 0 ; // Coordonnee s de la planete
                    UInt16 p = 0 ; // Coordonnee p de la planete
                    for( int i = 0 ; i < valeurs.Length ; ++i )
                    {
                        int indice = i+1 ;
                        if ( indice == indexGalaxie      )
                        {
                            g = Convert.ToUInt16( valeurs[i] ) ;
                        }
                        else if ( indice == indexSysteme      )
                        {
                            s = Convert.ToUInt16( valeurs[i] ) ;
                        }
                        else if ( indice == indexPlanete      )
                        {
                            p = Convert.ToUInt16( valeurs[i] ) ;
                        }
                        else if ( indice == indexLune         )
                        {
                            planete.AUneLune = valeurs[i].Contains("M") || valeurs[i].Contains("1") ;
                        }
                        else if ( indice == indexNom          )
                        {
                            // OMG its teh encoding h4cks
                            if( valeurs[i].Contains("m?") )
                            {
                                planete.Nom = "planète mère" ;
                            }
                            else if ( valeurs[i].Contains("d?") )
                            {
                                planete.Nom = "planète détruite" ;
                            }
                            else
                            {
                                planete.Nom = valeurs[i].Trim() ;
                            }
                        }
                        else if ( indice == indexJoueur       )
                        {
                            planete.Joueur = valeurs[i].Trim() ;
                        }
                        else if ( indice == indexAlliance     )
                        {
                            planete.Alliance = valeurs[i].Trim() ;
                        }
                        else if ( indice == indexStatus       )
                        {
                            planete.Status = Utils.lireStatus( valeurs[i] ) ;
                        }
                        else if ( indice == indexDateEtHeure  )
                        {
                            planete.DateEtHeureDeLecture = new DateTime(
                                System.Convert.ToInt32( Utils.Cherche(valeurs[i], @"(\d+)-\d+-\d+ \d+:\d+:\d+") ) ,
                                System.Convert.ToInt32( Utils.Cherche(valeurs[i], @"\d+-(\d+)-\d+ \d+:\d+:\d+") ) ,
                                System.Convert.ToInt32( Utils.Cherche(valeurs[i], @"\d+-\d+-(\d+) \d+:\d+:\d+") ) ,
                                System.Convert.ToInt32( Utils.Cherche(valeurs[i], @"\d+-\d+-\d+ (\d+):\d+:\d+") ) ,
                                System.Convert.ToInt32( Utils.Cherche(valeurs[i], @"\d+-\d+-\d+ \d+:(\d+):\d+") ) ,
                                System.Convert.ToInt32( Utils.Cherche(valeurs[i], @"\d+-\d+-\d+ \d+:\d+:(\d+)") ) ,
                                0 ) ;
                        }
                        else if ( indice == indexContributeur )
                        {
                            //OSEF, j'affiche pas le contributeur pour l'instant.
                        }
                    }
                    if ( g != 0 && s != 0 && p != 0 )
                    {
                        planete.coordonnees.Galaxie = g ;
                        planete.coordonnees.Systeme = s ;
                        planete.coordonnees.Planete = p ;
                        retour.Add( planete ) ;
                    }
                }
            }
            catch ( Exception ex )
            {
                throw new Exception("L'importation de la galaxie "+galaxie+" a échoué.", ex ) ;
            }
            return retour ;
        }

        // Fonctions d'export

        public class ResultatDExportationDeRapports
        {
            public int nombreDeRapportsCharges ;
            public String message           ;
            public ResultatDExportationDeRapports()
            {
                nombreDeRapportsCharges = 0 ;
                message = "" ;
            }
            public static ResultatDExportationDeRapports operator+( ResultatDExportationDeRapports a, ResultatDExportationDeRapports b )
            {
                ResultatDExportationDeRapports r = new ResultatDExportationDeRapports() ;
                r.nombreDeRapportsCharges = a.nombreDeRapportsCharges + b.nombreDeRapportsCharges ;
                return r ;
            }
        }
        public ResultatDExportationDeRapports ExporterLesRapports(Collection<RapportDEspionnage> rapports)
        {
            try
            {
                if ( rapports.Count == 0 ) throw new Exception("Il n'y a aucun rapport à exporter.") ;
                StringWriter sw = new StringWriter() ;
                sw.Write("data=coordinates=1,planet=2,datatime=3,report=4") ;
                foreach( RapportDEspionnage r in rapports )
                {
                    sw.Write("<->") ;
                    sw.Write("" + r.Coordonnees) ;
                    sw.Write("<||>" + r.NomDeLaPlanete) ;
                    sw.Write("<||>" + r.DateEtHeure.ToString(@"yyyy\-MM\-dd\ HH\:mm\:ss")) ;
                    sw.Write("<||>" + r.Texte ) ;
                }
                System.Net.HttpWebRequest requeteHTTP = (System.Net.WebRequest.Create( URL +"index.php?action=postspyingreports" ) as System.Net.HttpWebRequest) ;
                if ( requeteHTTP == null ) throw new Exception("Impossible de créer la requête HTTP !") ;
                requeteHTTP.KeepAlive = false ;
                requeteHTTP.Headers.Add("Cookie", "ogspy_id="+AuthString) ;
                requeteHTTP.ContentType = "application/x-www-form-urlencoded" ;
                requeteHTTP.UserAgent = "OGSClient 2.0.2492.1222 (061028)" ;
                requeteHTTP.Method = "POST" ;
                Stream s = requeteHTTP.GetRequestStream() ;
                byte[] buffer = System.Text.Encoding.GetEncoding("Latin1").GetBytes(sw.ToString()) ;
                s.Write(buffer, 0, buffer.Length ) ;
                s.Close() ;
                System.Net.HttpWebResponse reponse = (requeteHTTP.GetResponse() as System.Net.HttpWebResponse) ;
                if ( reponse == null ) throw new Exception("Erreur de requeteHTTP.GetResponse() !") ;
                Stream rep = reponse.GetResponseStream() ;
                StreamReader sr = new StreamReader(rep) ;
                String repData ;
                repData = sr.ReadToEnd() ;
                sr.Close() ;
                ResultatDExportationDeRapports resultat = new ResultatDExportationDeRapports() ;
                try
                {
                    resultat.nombreDeRapportsCharges = Convert.ToInt32( Utils.Cherche( repData, @":\s+(\d+)" ) ) ;
                    resultat.message = "Exportation de " + rapports.Count + " rapports OK (à priori...)" ;
                }
                catch ( Exception )
                {
                }
                return resultat ;
            }
            catch( Exception ex )
            {
                ResultatDExportationDeRapports resultat = new ResultatDExportationDeRapports() ;
                resultat.message = "L'exportation a échoué (" + ex.Message + ")" ;
                return resultat ; // 0 partout !
            }
        }

        public class ResultatDExportationDePlanetes
        {
            public int    planetesSoumises  ;
            public int    planetesAjoutees  ;
            public int    planetesMiseAJour ;
            public int    planetesObsoletes ;
            public int    nombreDEchecs     ;
            public double tempsDeTraitement ;
            public String message           ;
            public ResultatDExportationDePlanetes()
            {
                planetesSoumises  = 0 ;
                planetesAjoutees  = 0 ;
                planetesMiseAJour = 0 ;
                planetesObsoletes = 0 ;
                nombreDEchecs     = 0 ;
                tempsDeTraitement = 0 ;
                message           = "" ;
            }
            public static ResultatDExportationDePlanetes operator+( ResultatDExportationDePlanetes a, ResultatDExportationDePlanetes b )
            {
                ResultatDExportationDePlanetes r = new ResultatDExportationDePlanetes() ;
                r.planetesSoumises  = a.planetesSoumises  + b.planetesSoumises  ;
                r.planetesAjoutees  = a.planetesAjoutees  + b.planetesAjoutees  ;
                r.planetesMiseAJour = a.planetesMiseAJour + b.planetesMiseAJour ;
                r.planetesObsoletes = a.planetesObsoletes + b.planetesObsoletes ;
                r.nombreDEchecs     = a.nombreDEchecs     + b.nombreDEchecs     ;
                r.tempsDeTraitement = a.tempsDeTraitement + b.tempsDeTraitement ;
                return r ;
            }
        }
        public ResultatDExportationDePlanetes ExporterLesPlanetes(Collection<Planete> planetes)
        {
            try
            {
                if ( planetes.Count == 0 ) throw new Exception("Il n'y a aucune planètes à exporter.") ;
                
                StringWriter sw = new StringWriter() ;
                sw.Write("data=galaxy=1,system=2,row=3,moon=4,planetname=5,playername=6,allytag=7,status=8,datetime=9,sendername=10") ;
                foreach( Planete p in planetes )
                {
                    log.Debug("Planete " + p.coordonnees + " : \"" + p.Nom + "\" (joueur \"" + p.Joueur + "\")") ;
                    sw.Write("<->") ;
                    sw.Write("" + p.coordonnees.Galaxie ) ;
                    sw.Write("<||>" + p.coordonnees.Systeme ) ;
                    sw.Write("<||>" + p.coordonnees.Planete ) ;
                    sw.Write("<||>" + (p.AUneLune?"1":"0") ) ;
                    sw.Write("<||>" + p.Nom ) ;
                    sw.Write("<||>" + p.Joueur ) ;
                    sw.Write("<||>" + p.Alliance ) ;
                    sw.Write("<||>" + Utils.StatusEnChaine(p.Status) ) ;
                    sw.Write("<||>" + p.DateEtHeureDeLecture.ToString(@"yyyy\-MM\-dd\ HH\:mm\:ss") ) ;
                    sw.Write("<||>" + "-OFI-" + Login ) ;
                }
                System.Net.HttpWebRequest requeteHTTP = (System.Net.WebRequest.Create( URL +"index.php?action=postplanets" ) as System.Net.HttpWebRequest) ;
                if ( requeteHTTP == null ) throw new Exception("Impossible de créer la requête HTTP !") ;
                requeteHTTP.KeepAlive = false ;
                requeteHTTP.Headers.Add("Cookie", "ogspy_id="+AuthString) ;
                requeteHTTP.ContentType = "application/x-www-form-urlencoded" ;
                requeteHTTP.UserAgent = "OGSClient 2.0.2492.1222 (061028)" ;
                requeteHTTP.Method = "POST" ;
                Stream s = requeteHTTP.GetRequestStream() ;
                byte[] buffer = System.Text.Encoding.GetEncoding("Latin1").GetBytes(sw.ToString()) ;
                s.Write(buffer, 0, buffer.Length ) ;
                s.Close() ;
                System.Net.HttpWebResponse reponse = (requeteHTTP.GetResponse() as System.Net.HttpWebResponse) ;
                if ( reponse == null ) throw new Exception("Erreur de requeteHTTP.GetResponse() !") ;
                Stream r = reponse.GetResponseStream() ;
                StreamReader sr = new StreamReader(r) ;
                String repData ;
                repData = sr.ReadToEnd() ;
                sr.Close() ;
                ResultatDExportationDePlanetes resultat = new ResultatDExportationDePlanetes() ;
                try
                {
                    resultat.planetesSoumises  = Convert.ToInt32( Utils.Cherche( repData, @"soumises\s+:\s+(\d+)" ) ) ;
                    resultat.planetesAjoutees  = Convert.ToInt32( Utils.Cherche( repData, @"ins\S+es\s+:\s+(\d+)" ) ) ;
                    resultat.planetesMiseAJour = Convert.ToInt32( Utils.Cherche( repData, @"jour\s+:\s+(\d+)" ) ) ;
                    resultat.planetesObsoletes = Convert.ToInt32( Utils.Cherche( repData, @"tes\s+:\s+(\d+)" ) ) ;
                    resultat.nombreDEchecs     = Convert.ToInt32( Utils.Cherche( repData, @"chec\s+:\s+(\d+)" ) ) ;
                    resultat.tempsDeTraitement = Convert.ToDouble( Utils.Cherche( repData, @"traitement\s+:\s+([0-9\.]+)\s+sec" ) ) ;
                }
                catch ( Exception )
                {
                }
                return resultat ;
            }
            catch( Exception ex )
            {
                ResultatDExportationDePlanetes resultat = new ResultatDExportationDePlanetes() ;
                resultat.message = "L'exportation a échoué (" + ex.Message + ")" ;
                return resultat ; // 0 partout !
            }
        }
        

    }

    public class Utils
    {
        public static String Cherche( string chaine, string regex ) 
        {
            Regex r = new Regex( regex, RegexOptions.IgnoreCase ) ;
            Match m = r.Match( chaine );
            if ( m.Success )
            {
                return m.Groups[1].Value ;
            }
            return "" ;
        }

        public static String EnlevePoints( String chaine )
        {
            String r = "" ;
            foreach ( char c in chaine )
            {
                if ( c != '.' )
                {
                    r += c ;
                }
            }
            return r ;
        }

        static public StatusJoueur lireStatus( string status )
        {
            StatusJoueur sj ;
            sj = StatusJoueur.Normal ;
                 if ( status.Contains("b") ) sj = StatusJoueur.Bloque      ;
            else if ( status.Contains("v") ) sj = StatusJoueur.Vacances    ;
            else if ( status.Contains("I") ) sj = StatusJoueur.InactifLong ;
            else if ( status.Contains("i") ) sj = StatusJoueur.Inactif     ;
            else if ( status.Contains("d") ) sj = StatusJoueur.Debutant    ;
            return sj ;
        }

        public static Color calculeLaCouleur(double rapport, double rapportDesCouleurs,
            Color CouleurRecent, Color CouleurMilieu, Color CouleurAncien)
        {
            Color resultat = new Color() ;
            if ( rapport > 1.0 )
            {
                resultat = Color.LightBlue ;
            }
            else if ( rapport >= 1.0 )
            {
                resultat = CouleurRecent ;
            }
            else if ( rapport <= 0.0 )
            {
                resultat = CouleurAncien ;
            }
            else
            {
                if ( rapport > rapportDesCouleurs )
                {
                    resultat = Color.FromArgb(
                        (int)((CouleurRecent.R-CouleurMilieu.R)*((rapport-rapportDesCouleurs)/(1-rapportDesCouleurs))) + CouleurMilieu.R ,
                        (int)((CouleurRecent.G-CouleurMilieu.G)*((rapport-rapportDesCouleurs)/(1-rapportDesCouleurs))) + CouleurMilieu.G ,
                        (int)((CouleurRecent.B-CouleurMilieu.B)*((rapport-rapportDesCouleurs)/(1-rapportDesCouleurs))) + CouleurMilieu.B 
                    ) ;
                }
                else
                {
                    resultat = Color.FromArgb(
                        (int)((CouleurMilieu.R-CouleurAncien.R)*(rapport/rapportDesCouleurs)) + CouleurAncien.R ,
                        (int)((CouleurMilieu.G-CouleurAncien.G)*(rapport/rapportDesCouleurs)) + CouleurAncien.G ,
                        (int)((CouleurMilieu.B-CouleurAncien.B)*(rapport/rapportDesCouleurs)) + CouleurAncien.B 
                    ) ;
                }
            }
            return resultat ;
        }

        public static string affEntier( long entier )
        {
            return String.Format("{0:#' '###' '###' '##0}", entier) ;
        }
        public static string affEntier( UInt32 entier )
        {
            return String.Format("{0:#' '###' '###' '##0}", entier) ;
        }
        public static string affEntier( int entier )
        {
            return String.Format("{0:#' '###' '###' '##0}", entier) ;
        }

        public static string affTemps( long secondes )
        {
            return String.Format("{0}:{1:00}:{2:00}", secondes/3600, (secondes%3600)/60, secondes%60 ) ;
        }

        public static string StatusEnChaine(StatusJoueur s)
        {
            string r = "-" ;
            switch ( s )
            {
                case StatusJoueur.Normal      : r = ""  ; break ;
                case StatusJoueur.Debutant    : r = "d" ; break ;
                case StatusJoueur.Inactif     : r = "i" ; break ;
                case StatusJoueur.InactifLong : r = "I" ; break ;
                case StatusJoueur.Vacances    : r = "v" ; break ;
                case StatusJoueur.Bloque      : r = "b" ; break ;
            }
            return r ;
        }

        private static String fond = "#1C284E" ;
        private static string CompleteAvecEspacesPourForum( String chaine, UInt32 entier  )
        {
            int taille = chaine.Length ;
            taille = Math.Max(38 - taille - affEntierAvecPoints(entier).Length, 0) ;
            return "[color="+fond+"]" + new String('.', taille) + "[/color]" ;
        }
        public static string affEntierAvecPoints( UInt32 entier )
        {
            String valeur = "" ;
            if ( entier > 999999999 )
            {
                valeur += String.Format("{0:###'.'###'.'###'.'##0}", entier) ;
            }
            else if ( entier > 999999 ) 
            {
                valeur += String.Format("{0:###'.'###'.'##0}", entier) ;
            }
            else if ( entier > 999 )
            {
                valeur += String.Format("{0:###'.'##0}", entier) ;
            }
            else 
            {
                valeur += String.Format("{0:##0}", entier) ;
            }

            return valeur ;
        }
        public static string affEntierAvecPoints( Int32 entier )
        {
            String valeur = "" ;
            if ( entier > 999999999 )
            {
                valeur += String.Format("{0:###'.'###'.'###'.'##0}", entier) ;
            }
            else if ( entier > 999999 ) 
            {
                valeur += String.Format("{0:###'.'###'.'##0}", entier) ;
            }
            else if ( entier > 999 )
            {
                valeur += String.Format("{0:###'.'##0}", entier) ;
            }
            else 
            {
                valeur += String.Format("{0:##0}", entier) ;
            }

            return valeur ;
        }
        private static bool retourALaLigne = true ;
        private static string AfficherUnChamps( String entete, UInt32 valeur, UInt32 valeurElevee )
        {
            if ( valeur == 0 ) return "" ;
            String retour = "" ;
            if ( retourALaLigne ) retour += "\r\n" ;
            else retour += "[color="+fond+"].....[/color]" ;
            retourALaLigne = !retourALaLigne ;
            if ( valeur >= valeurElevee )
            {
                retour += entete + CompleteAvecEspacesPourForum(entete, valeur) + "[color=#FF0000][b]" + affEntierAvecPoints(valeur) + "[/b][/color]\t" ;
            }
            else
            {
                retour += entete + CompleteAvecEspacesPourForum(entete, valeur) + "[color=#FFCC00]" + affEntierAvecPoints(valeur) + "[/color]\t" ;
            }
            return retour ;
        }
        private static string AfficherUnChamps2( String entete, UInt32 valeur, UInt32 valeurElevee )
        {
            if ( valeur == 0 ) return "" ;
            if ( valeur >= valeurElevee )
            {
                return entete + "[color=#FF0000][b]" + affEntierAvecPoints(valeur) + "[/b][/color]\r\n" ;
            }
            else
            {
                return entete + "[color=#FFCC00]" + affEntierAvecPoints(valeur) + "[/color]\r\n" ;
            }
        }

        public static string Conversion( RapportDEspionnage rapport )
        {
            String s = "" ;
            s += "[quote=\"      >>>> ["+rapport.Coordonnees+"] <<<<           >>>> by Mack's converter <<<<       \"]" ;
            if ( rapport.estUnPigeon() )
            {
                s += "C'est un magnifique pigeon pillable sans risque :D !\r\n" ;
            }
            s += "\r\n" ;
            s += "Il pèse " + rapport.Ressources.NombreDeGrandsTransporteurs() + " GTs et " + rapport.FlotteAQuai.ValeurEnRuines().NombreDeRecycleurs() + " RCs\r\n" ;
            s += "[font=Courier New]" ;
            s += "Matières premières sur [b]" + rapport.NomDeLaPlanete + "[/b] [" + rapport.Coordonnees + "] le [b]" + rapport.DateEtHeure.ToString(@"MM\-dd\ HH\:mm\:ss") + "[/b]:" ;
                s += "\r\n[color=#00CC00][u]Ressources[/u][/color]" ;
                retourALaLigne = true ;
                s += AfficherUnChamps( "Métal: "    , rapport.Ressources.Metal    , 1000000 ) ;
                s += AfficherUnChamps( "Cristal: "  , rapport.Ressources.Cristal  , 1000000 ) ;
                s += AfficherUnChamps( "Deutérium: ", rapport.Ressources.Deuterium, 1000000 ) ;
                s += AfficherUnChamps( "Energie: "  , rapport.Ressources.Energie  ,   30000 ) ;
            if ( rapport.FlotteAQuaiEstValide ){
                s += "\r\n[color=#00CC00][u]Flotte[/u][/color]" ;
                retourALaLigne = true ;
                s += AfficherUnChamps( "Petit transporteur "      , rapport.FlotteAQuai.PetitsTransporteurs     , 2000 ) ;
                s += AfficherUnChamps( "Grand transporteur "      , rapport.FlotteAQuai.GrandTransporteurs      , 1000 ) ;
                s += AfficherUnChamps( "Chasseur léger "          , rapport.FlotteAQuai.ChasseursLegers         , 2000 ) ;
                s += AfficherUnChamps( "Chasseur lourd "          , rapport.FlotteAQuai.ChasseursLourds         , 1000 ) ;
                s += AfficherUnChamps( "Croiseur "                , rapport.FlotteAQuai.Croiseurs               ,  500 ) ;
                s += AfficherUnChamps( "Vaisseau de bataille "    , rapport.FlotteAQuai.VaisseauxDeBataille     ,  300 ) ;
                s += AfficherUnChamps( "Vaisseau de colonisation ", rapport.FlotteAQuai.VaisseauxDeColonisation ,  100 ) ;
                s += AfficherUnChamps( "Recycleur "               , rapport.FlotteAQuai.Recycleurs              ,  500 ) ;
                s += AfficherUnChamps( "Sonde espionnage "        , rapport.FlotteAQuai.SondesDEspionnage       , 2000 ) ;
                s += AfficherUnChamps( "Satellite solaire "       , rapport.FlotteAQuai.SatellitesSolaires      , 1000 ) ;
                s += AfficherUnChamps( "Bombardier "              , rapport.FlotteAQuai.Bombardiers             ,  100 ) ;
                s += AfficherUnChamps( "Destructeur "             , rapport.FlotteAQuai.Destructeurs            ,  100 ) ;
                s += AfficherUnChamps( "Traqueur "                , rapport.FlotteAQuai.Battlecruiser           ,  300 ) ;
                s += AfficherUnChamps( "Étoile de la mort "       , rapport.FlotteAQuai.EtoilesDeLaMort         ,    2 ) ;
            if ( rapport.DefensesEstValide ) {
                s += "\r\n[color=#00CC00][u]Défense[/u][/color]" ;
                retourALaLigne = true ;
                s += AfficherUnChamps( "Lanceur de missiles "     , rapport.Defenses.LanceursDeMissiles         , 2000 ) ;
                s += AfficherUnChamps( "Artillerie laser légère " , rapport.Defenses.ArtilleriesLaserLegeres    , 2000 ) ;
                s += AfficherUnChamps( "Artillerie laser lourde " , rapport.Defenses.ArtilleriesLaserLourdes    , 1000 ) ;
                s += AfficherUnChamps( "Artillerie à ions "       , rapport.Defenses.ArtilleriesAIons           , 1000 ) ;
                s += AfficherUnChamps( "Canon de Gauss "          , rapport.Defenses.CanonsDeGauss              ,  300 ) ;
                s += AfficherUnChamps( "Lanceur de plasma "       , rapport.Defenses.LanceursDePlasma           ,  150 ) ;
                s += AfficherUnChamps( "Petit bouclier "          , rapport.Defenses.PetitBouclier              ,    2 ) ;
                s += AfficherUnChamps( "Grand bouclier "          , rapport.Defenses.GrandBouclier              ,    2 ) ;
                s += AfficherUnChamps( "Missile Interception "    , rapport.Defenses.MissilesDInterception      ,   50 ) ;
                s += AfficherUnChamps( "Missile Interplanétaire " , rapport.Defenses.MissilesInterplanetaires   ,   30 ) ;
            if ( rapport.BatimentsEstValide ) {
                s += "\r\n[color=#00CC00][u]Bâtiments[/u][/color]" ;
                retourALaLigne = true ;
                s += AfficherUnChamps( "Mine de métal "                 , rapport.Batiments.MineDeMetal             , 25 ) ;
                s += AfficherUnChamps( "Mine de cristal "               , rapport.Batiments.MineDeCristal           , 25 ) ;
                s += AfficherUnChamps( "Synthétiseur de deutérium "     , rapport.Batiments.SynthetiseurDeDeuterium , 22 ) ;
                s += AfficherUnChamps( "Centrale électrique de fusion " , rapport.Batiments.CentraleFusion          , 12 ) ;
                s += AfficherUnChamps( "Centrale électrique solaire "   , rapport.Batiments.CentraleSolaire         , 25 ) ;
                s += AfficherUnChamps( "Usine de robots "               , rapport.Batiments.UsineDeRobots           , 11 ) ;
                s += AfficherUnChamps( "Usine de nanites "              , rapport.Batiments.UsineDeNanites          ,  3 ) ;
                s += AfficherUnChamps( "Chantier spatial "              , rapport.Batiments.ChantierSpatial         , 10 ) ;
                s += AfficherUnChamps( "Hangar de métal "               , rapport.Batiments.HangarDeMetal           ,  8 ) ;
                s += AfficherUnChamps( "Hangar de cristal "             , rapport.Batiments.HangarDeCristal         ,  8 ) ;
                s += AfficherUnChamps( "Réservoir de deutérium "        , rapport.Batiments.ReservoirDeDeuterium    ,  8 ) ;
                s += AfficherUnChamps( "Laboratoire de recherche "      , rapport.Batiments.LaboratoireDeRecherche  , 12 ) ;
                s += AfficherUnChamps( "Silo de missiles "              , rapport.Batiments.SiloDeMissiles          ,  6 ) ;
                s += AfficherUnChamps( "Terraformeur "                  , rapport.Batiments.Terraformeur            ,  4 ) ;
                s += AfficherUnChamps( "Base lunaire "                  , rapport.Batiments.BaseLunaire             ,  7 ) ;
                s += AfficherUnChamps( "Phalange de capteur "           , rapport.Batiments.PhalangeDeCapteur       ,  5 ) ;
                s += AfficherUnChamps( "Porte de saut spatial "         , rapport.Batiments.PorteDeSautSpatial      ,  2 ) ;
            if ( rapport.RecherchesEstValide ) {
                s += "\r\n[color=#00CC00][u]Recherche[/u][/color]" ;
                retourALaLigne = true ;
                s += AfficherUnChamps( "Technologie Espionnage "            , rapport.Recherches.Espionnage                     , 13 ) ;
                s += AfficherUnChamps( "Technologie Ordinateur "            , rapport.Recherches.Ordinateur                     , 14 ) ;
                s += AfficherUnChamps( "Technologie Armes "                 , rapport.Recherches.Armes                          , 14 ) ;
                s += AfficherUnChamps( "Technologie Bouclier "              , rapport.Recherches.Bouclier                       , 14 ) ;
                s += AfficherUnChamps( "Protection des vaisseaux spatiaux " , rapport.Recherches.ProtectionDesVaisseauxSpatiaux , 14 ) ;
                s += AfficherUnChamps( "Technologie Energie "               , rapport.Recherches.Energie                        , 12 ) ;
                s += AfficherUnChamps( "Technologie Hyperespace "           , rapport.Recherches.Hyperespace                    ,  9 ) ;
                s += AfficherUnChamps( "Réacteur à combustion "             , rapport.Recherches.ReacteurACombustion            , 12 ) ;
                s += AfficherUnChamps( "Réacteur à impulsion "              , rapport.Recherches.ReacteurAImpulsion             , 10 ) ;
                s += AfficherUnChamps( "Propulsion hyperespace "            , rapport.Recherches.PropulsionHyperespace          ,  8 ) ;
                s += AfficherUnChamps( "Technologie Laser "                 , rapport.Recherches.Laser                          , 11 ) ;
                s += AfficherUnChamps( "Technologie Ions "                  , rapport.Recherches.Ions                           , 10 ) ;
                s += AfficherUnChamps( "Technologie Plasma "                , rapport.Recherches.Plasma                         ,  8 ) ;
                s += AfficherUnChamps( "Technologie Graviton "              , rapport.Recherches.Graviton                       ,  1 ) ;
            }}}}
            s += "[/font]" ;
            s += "[/quote]\r\n" ;
            return s ;
        }
        public static string ConversionSansBaliseFont( RapportDEspionnage rapport )
        {
            String s = "" ;
            s += "[quote=\"      >>>> ["+rapport.Coordonnees+"] <<<<           >>>> by Mack's converter <<<<       \"]" ;
            if ( rapport.estUnPigeon() )
            {
                s += "C'est un magnifique pigeon pillable sans risque :D !\r\n" ;
            }
            s += "Il pèse " + rapport.Ressources.NombreDeGrandsTransporteurs() + " GTs et " + rapport.FlotteAQuai.ValeurEnRuines().NombreDeRecycleurs() + " RCs\r\n" ;
            s += "\r\n" ;
            s += "Matières premières sur [b]" + rapport.NomDeLaPlanete + "[/b] [" + rapport.Coordonnees + "] le [b]" + rapport.DateEtHeure.ToString(@"MM\-dd\ HH\:mm\:ss") + "[/b]:" ;
                s += "\r\n[color=#00CC00][u]Ressources[/u][/color]\r\n" ;
                s += AfficherUnChamps2( "Métal: "    , rapport.Ressources.Metal    , 1000000 ) ;
                s += AfficherUnChamps2( "Cristal: "  , rapport.Ressources.Cristal  , 1000000 ) ;
                s += AfficherUnChamps2( "Deutérium: ", rapport.Ressources.Deuterium, 1000000 ) ;
                s += AfficherUnChamps2( "Energie: "  , rapport.Ressources.Energie  ,   30000 ) ;
            if ( rapport.FlotteAQuaiEstValide ){
                s += "\r\n[color=#00CC00][u]Flotte[/u][/color]\r\n" ;
                s += AfficherUnChamps2( "Petit transporteur "      , rapport.FlotteAQuai.PetitsTransporteurs     , 2000 ) ;
                s += AfficherUnChamps2( "Grand transporteur "      , rapport.FlotteAQuai.GrandTransporteurs      , 1000 ) ;
                s += AfficherUnChamps2( "Chasseur léger "          , rapport.FlotteAQuai.ChasseursLegers         , 2000 ) ;
                s += AfficherUnChamps2( "Chasseur lourd "          , rapport.FlotteAQuai.ChasseursLourds         , 1000 ) ;
                s += AfficherUnChamps2( "Croiseur "                , rapport.FlotteAQuai.Croiseurs               ,  500 ) ;
                s += AfficherUnChamps2( "Vaisseau de bataille "    , rapport.FlotteAQuai.VaisseauxDeBataille     ,  300 ) ;
                s += AfficherUnChamps2( "Vaisseau de colonisation ", rapport.FlotteAQuai.VaisseauxDeColonisation ,  100 ) ;
                s += AfficherUnChamps2( "Recycleur "               , rapport.FlotteAQuai.Recycleurs              ,  500 ) ;
                s += AfficherUnChamps2( "Sonde espionnage "        , rapport.FlotteAQuai.SondesDEspionnage       , 2000 ) ;
                s += AfficherUnChamps2( "Satellite solaire "       , rapport.FlotteAQuai.SatellitesSolaires      , 1000 ) ;
                s += AfficherUnChamps2( "Bombardier "              , rapport.FlotteAQuai.Bombardiers             ,  100 ) ;
                s += AfficherUnChamps2( "Destructeur "             , rapport.FlotteAQuai.Destructeurs            ,  100 ) ;
                s += AfficherUnChamps2( "Traqueur "                , rapport.FlotteAQuai.Battlecruiser           ,  300 ) ;
                s += AfficherUnChamps2( "Étoile de la mort "       , rapport.FlotteAQuai.EtoilesDeLaMort         ,    2 ) ;
            if ( rapport.DefensesEstValide ) {
                s += "\r\n[color=#00CC00][u]Défense[/u][/color]\r\n" ;
                s += AfficherUnChamps2( "Lanceur de missiles "     , rapport.Defenses.LanceursDeMissiles         , 2000 ) ;
                s += AfficherUnChamps2( "Artillerie laser légère " , rapport.Defenses.ArtilleriesLaserLegeres    , 2000 ) ;
                s += AfficherUnChamps2( "Artillerie laser lourde " , rapport.Defenses.ArtilleriesLaserLourdes    , 1000 ) ;
                s += AfficherUnChamps2( "Artillerie à ions "       , rapport.Defenses.ArtilleriesAIons           , 1000 ) ;
                s += AfficherUnChamps2( "Canon de Gauss "          , rapport.Defenses.CanonsDeGauss              ,  300 ) ;
                s += AfficherUnChamps2( "Lanceur de plasma "       , rapport.Defenses.LanceursDePlasma           ,  150 ) ;
                s += AfficherUnChamps2( "Petit bouclier "          , rapport.Defenses.PetitBouclier              ,    2 ) ;
                s += AfficherUnChamps2( "Grand bouclier "          , rapport.Defenses.GrandBouclier              ,    2 ) ;
                s += AfficherUnChamps2( "Missile Interception "    , rapport.Defenses.MissilesDInterception      ,   50 ) ;
                s += AfficherUnChamps2( "Missile Interplanétaire " , rapport.Defenses.MissilesInterplanetaires   ,   30 ) ;
            if ( rapport.BatimentsEstValide ) {
                s += "\r\n[color=#00CC00][u]Bâtiments[/u][/color]\r\n" ;
                s += AfficherUnChamps2( "Mine de métal "                 , rapport.Batiments.MineDeMetal             , 25 ) ;
                s += AfficherUnChamps2( "Mine de cristal "               , rapport.Batiments.MineDeCristal           , 25 ) ;
                s += AfficherUnChamps2( "Synthétiseur de deutérium "     , rapport.Batiments.SynthetiseurDeDeuterium , 22 ) ;
                s += AfficherUnChamps2( "Centrale électrique de fusion " , rapport.Batiments.CentraleFusion          , 12 ) ;
                s += AfficherUnChamps2( "Centrale électrique solaire "   , rapport.Batiments.CentraleSolaire         , 25 ) ;
                s += AfficherUnChamps2( "Usine de robots "               , rapport.Batiments.UsineDeRobots           , 11 ) ;
                s += AfficherUnChamps2( "Usine de nanites "              , rapport.Batiments.UsineDeNanites          ,  3 ) ;
                s += AfficherUnChamps2( "Chantier spatial "              , rapport.Batiments.ChantierSpatial         , 10 ) ;
                s += AfficherUnChamps2( "Hangar de métal "               , rapport.Batiments.HangarDeMetal           ,  8 ) ;
                s += AfficherUnChamps2( "Hangar de cristal "             , rapport.Batiments.HangarDeCristal         ,  8 ) ;
                s += AfficherUnChamps2( "Réservoir de deutérium "        , rapport.Batiments.ReservoirDeDeuterium    ,  8 ) ;
                s += AfficherUnChamps2( "Laboratoire de recherche "      , rapport.Batiments.LaboratoireDeRecherche  , 12 ) ;
                s += AfficherUnChamps2( "Silo de missiles "              , rapport.Batiments.SiloDeMissiles          ,  6 ) ;
                s += AfficherUnChamps2( "Terraformeur "                  , rapport.Batiments.Terraformeur            ,  4 ) ;
                s += AfficherUnChamps2( "Base lunaire "                  , rapport.Batiments.BaseLunaire             ,  7 ) ;
                s += AfficherUnChamps2( "Phalange de capteur "           , rapport.Batiments.PhalangeDeCapteur       ,  5 ) ;
                s += AfficherUnChamps2( "Porte de saut spatial "         , rapport.Batiments.PorteDeSautSpatial      ,  2 ) ;
            if ( rapport.RecherchesEstValide ) {
                s += "\r\n[color=#00CC00][u]Recherche[/u][/color]\r\n" ;
                s += AfficherUnChamps2( "Technologie Espionnage "            , rapport.Recherches.Espionnage                     , 13 ) ;
                s += AfficherUnChamps2( "Technologie Ordinateur "            , rapport.Recherches.Ordinateur                     , 14 ) ;
                s += AfficherUnChamps2( "Technologie Armes "                 , rapport.Recherches.Armes                          , 14 ) ;
                s += AfficherUnChamps2( "Technologie Bouclier "              , rapport.Recherches.Bouclier                       , 14 ) ;
                s += AfficherUnChamps2( "Protection des vaisseaux spatiaux " , rapport.Recherches.ProtectionDesVaisseauxSpatiaux , 14 ) ;
                s += AfficherUnChamps2( "Technologie Energie "               , rapport.Recherches.Energie                        , 12 ) ;
                s += AfficherUnChamps2( "Technologie Hyperespace "           , rapport.Recherches.Hyperespace                    ,  9 ) ;
                s += AfficherUnChamps2( "Réacteur à combustion "             , rapport.Recherches.ReacteurACombustion            , 12 ) ;
                s += AfficherUnChamps2( "Réacteur à impulsion "              , rapport.Recherches.ReacteurAImpulsion             , 10 ) ;
                s += AfficherUnChamps2( "Propulsion hyperespace "            , rapport.Recherches.PropulsionHyperespace          ,  8 ) ;
                s += AfficherUnChamps2( "Technologie Laser "                 , rapport.Recherches.Laser                          , 11 ) ;
                s += AfficherUnChamps2( "Technologie Ions "                  , rapport.Recherches.Ions                           , 10 ) ;
                s += AfficherUnChamps2( "Technologie Plasma "                , rapport.Recherches.Plasma                         ,  8 ) ;
                s += AfficherUnChamps2( "Technologie Graviton "              , rapport.Recherches.Graviton                       ,  1 ) ;
            }}}}
            s += "[/quote]\r\n" ;
            return s ;
        }
        private static string AfficherUnChampsTableHTML( String entete, UInt32 valeur, UInt32 valeurElevee )
        {
            if ( valeur == 0 ) return "" ;
            String espace = "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>" ;
            String retour = "" ;
            if ( retourALaLigne ) retour += "</tr><tr>\r\n" ;
            retourALaLigne = !retourALaLigne ;
            if ( valeur >= valeurElevee )
            {
                return "<td>" + entete + "</td>" + espace + "<td align=\"right\"><b>" + Utils.affEntierAvecPoints(valeur) + "</b></td>" + espace + retour + "\r\n" ;
            }
            else
            {
                return "<td>" + entete + "</td>" + espace + "<td align=\"right\">" + Utils.affEntierAvecPoints(valeur) + "</td>" + espace + retour + "\r\n" ;
            }
        }
        public static string ConversionEnHTML( RapportDEspionnage rapport )
        {
            String s = 
"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n" +
"<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" >\r\n" +
"   <head>\r\n" +
"       <title>Rapport d'espionnage Ogame</title>\r\n" +
"       <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\r\n" +
"       <style type=\"text/css\">\r\n" +
"b\r\n" +
"{\r\n" +
"   color: #FF8080 ;\r\n" +
"}\r\n" +
"h1\r\n" +
"{\r\n" +
"   font-size: 60% ;\r\n" +
"   font-family: Arial, Verdana, serif;\r\n" +
"   font-weight: bold ;\r\n" +
"   color: white ;\r\n" +
"   background-color: #100040 ;\r\n" +
"   width: 100% ;\r\n" +
"   border-width: 1px ;\r\n" +
"   border-color: #3000D0 ;\r\n" +
"   border-style: solid ;\r\n" +
"   margin: 1px ;\r\n" +
"}\r\n" +
"tr\r\n" +
"{\r\n" +
"   width: 100% ;\r\n" +
"}\r\n" +
"td\r\n" +
"{\r\n" +
"   font-size: 60% ;\r\n" +
"   font-family: Arial, Verdana, serif;\r\n" +
"   color: #E8E0FF ;\r\n" +
"   padding: 1px, 10px ;\r\n" +
"}\r\n" +
"       </style>\r\n" +
"   </head>\r\n" +
"   <body bgcolor=\"#300080\">\r\n"                
            ; // String s
            s += "<h1>Matières premières sur " + rapport.NomDeLaPlanete + " [" + rapport.Coordonnees + "] le " + rapport.DateEtHeure.ToString(@"MM\-dd\ HH\:mm\:ss") + "</h1>\r\n" ;
                s += "<table><tr>" ;
                retourALaLigne = false ;
                s += AfficherUnChampsTableHTML( "Métal: "    , rapport.Ressources.Metal    , 1000000 ) ;
                s += AfficherUnChampsTableHTML( "Cristal: "  , rapport.Ressources.Cristal  , 1000000 ) ;
                s += AfficherUnChampsTableHTML( "Deutérium: ", rapport.Ressources.Deuterium, 1000000 ) ;
                s += AfficherUnChampsTableHTML( "Energie: "  , rapport.Ressources.Energie  ,   30000 ) ;
                s += "</tr></table>" ;
            if ( rapport.FlotteAQuaiEstValide ){
                s += "<h1>Flotte</h1>\r\n" ;
                s += "<table><tr>" ;
                retourALaLigne = false ;
                s += AfficherUnChampsTableHTML( "Petit transporteur "      , rapport.FlotteAQuai.PetitsTransporteurs     , 2000 ) ;
                s += AfficherUnChampsTableHTML( "Grand transporteur "      , rapport.FlotteAQuai.GrandTransporteurs      , 1000 ) ;
                s += AfficherUnChampsTableHTML( "Chasseur léger "          , rapport.FlotteAQuai.ChasseursLegers         , 2000 ) ;
                s += AfficherUnChampsTableHTML( "Chasseur lourd "          , rapport.FlotteAQuai.ChasseursLourds         , 1000 ) ;
                s += AfficherUnChampsTableHTML( "Croiseur "                , rapport.FlotteAQuai.Croiseurs               ,  500 ) ;
                s += AfficherUnChampsTableHTML( "Vaisseau de bataille "    , rapport.FlotteAQuai.VaisseauxDeBataille     ,  300 ) ;
                s += AfficherUnChampsTableHTML( "Vaisseau de colonisation ", rapport.FlotteAQuai.VaisseauxDeColonisation ,  100 ) ;
                s += AfficherUnChampsTableHTML( "Recycleur "               , rapport.FlotteAQuai.Recycleurs              ,  500 ) ;
                s += AfficherUnChampsTableHTML( "Sonde espionnage "        , rapport.FlotteAQuai.SondesDEspionnage       , 2000 ) ;
                s += AfficherUnChampsTableHTML( "Bombardier "              , rapport.FlotteAQuai.Bombardiers             ,  100 ) ;
                s += AfficherUnChampsTableHTML( "Satellite solaire "       , rapport.FlotteAQuai.SatellitesSolaires      , 1000 ) ;
                s += AfficherUnChampsTableHTML( "Destructeur "             , rapport.FlotteAQuai.Destructeurs            ,  100 ) ;
                s += AfficherUnChampsTableHTML( "Traqueur "                , rapport.FlotteAQuai.Battlecruiser           ,  300 ) ;
                s += AfficherUnChampsTableHTML( "Étoile de la mort "       , rapport.FlotteAQuai.EtoilesDeLaMort         ,    2 ) ;
                s += "</tr></table>" ;
            if ( rapport.DefensesEstValide ) {
                s += "<h1>Défense</h1>\r\n" ;
                s += "<table><tr>" ;
                retourALaLigne = false ;
                s += AfficherUnChampsTableHTML( "Lanceur de missiles "     , rapport.Defenses.LanceursDeMissiles         , 2000 ) ;
                s += AfficherUnChampsTableHTML( "Artillerie laser légère " , rapport.Defenses.ArtilleriesLaserLegeres    , 2000 ) ;
                s += AfficherUnChampsTableHTML( "Artillerie laser lourde " , rapport.Defenses.ArtilleriesLaserLourdes    , 1000 ) ;
                s += AfficherUnChampsTableHTML( "Canon de Gauss "          , rapport.Defenses.CanonsDeGauss              ,  300 ) ;
                s += AfficherUnChampsTableHTML( "Artillerie à ions "       , rapport.Defenses.ArtilleriesAIons           , 1000 ) ;
                s += AfficherUnChampsTableHTML( "Lanceur de plasma "       , rapport.Defenses.LanceursDePlasma           ,  150 ) ;
                s += AfficherUnChampsTableHTML( "Petit bouclier "          , rapport.Defenses.PetitBouclier              ,    2 ) ;
                s += AfficherUnChampsTableHTML( "Grand bouclier "          , rapport.Defenses.GrandBouclier              ,    2 ) ;
                s += AfficherUnChampsTableHTML( "Missile Interception "    , rapport.Defenses.MissilesDInterception      ,   50 ) ;
                s += AfficherUnChampsTableHTML( "Missile Interplanétaire " , rapport.Defenses.MissilesInterplanetaires   ,   30 ) ;
                s += "</tr></table>" ;
            if ( rapport.BatimentsEstValide ) {
                s += "<h1>Bâtiments</h1>\r\n" ;
                s += "<table><tr>" ;
                retourALaLigne = false ;
                s += AfficherUnChampsTableHTML( "Mine de métal "                 , rapport.Batiments.MineDeMetal             , 25 ) ;
                s += AfficherUnChampsTableHTML( "Mine de cristal "               , rapport.Batiments.MineDeCristal           , 25 ) ;
                s += AfficherUnChampsTableHTML( "Synthétiseur de deutérium "     , rapport.Batiments.SynthetiseurDeDeuterium , 22 ) ;
                s += AfficherUnChampsTableHTML( "Centrale électrique solaire "   , rapport.Batiments.CentraleSolaire         , 25 ) ;
                s += AfficherUnChampsTableHTML( "Centrale électrique de fusion " , rapport.Batiments.CentraleFusion          , 12 ) ;
                s += AfficherUnChampsTableHTML( "Usine de robots "               , rapport.Batiments.UsineDeRobots           , 11 ) ;
                s += AfficherUnChampsTableHTML( "Usine de nanites "              , rapport.Batiments.UsineDeNanites          ,  3 ) ;
                s += AfficherUnChampsTableHTML( "Chantier spatial "              , rapport.Batiments.ChantierSpatial         , 10 ) ;
                s += AfficherUnChampsTableHTML( "Hangar de métal "               , rapport.Batiments.HangarDeMetal           ,  8 ) ;
                s += AfficherUnChampsTableHTML( "Hangar de cristal "             , rapport.Batiments.HangarDeCristal         ,  8 ) ;
                s += AfficherUnChampsTableHTML( "Réservoir de deutérium "        , rapport.Batiments.ReservoirDeDeuterium    ,  8 ) ;
                s += AfficherUnChampsTableHTML( "Laboratoire de recherche "      , rapport.Batiments.LaboratoireDeRecherche  , 12 ) ;
                s += AfficherUnChampsTableHTML( "Terraformeur "                  , rapport.Batiments.Terraformeur            ,  4 ) ;
                s += AfficherUnChampsTableHTML( "Silo de missiles "              , rapport.Batiments.SiloDeMissiles          ,  6 ) ;
                s += AfficherUnChampsTableHTML( "Base lunaire "                  , rapport.Batiments.BaseLunaire             ,  7 ) ;
                s += AfficherUnChampsTableHTML( "Phalange de capteur "           , rapport.Batiments.PhalangeDeCapteur       ,  5 ) ;
                s += AfficherUnChampsTableHTML( "Porte de saut spatial "         , rapport.Batiments.PorteDeSautSpatial      ,  2 ) ;
                s += "</tr></table>" ;
            if ( rapport.RecherchesEstValide ) {
                s += "<h1>Recherche</h1>\r\n" ;
                s += "<table><tr>" ;
                retourALaLigne = false ;
                s += AfficherUnChampsTableHTML( "Technologie Espionnage "            , rapport.Recherches.Espionnage                     , 13 ) ;
                s += AfficherUnChampsTableHTML( "Technologie Ordinateur "            , rapport.Recherches.Ordinateur                     , 14 ) ;
                s += AfficherUnChampsTableHTML( "Technologie Armes "                 , rapport.Recherches.Armes                          , 14 ) ;
                s += AfficherUnChampsTableHTML( "Technologie Bouclier "              , rapport.Recherches.Bouclier                       , 14 ) ;
                s += AfficherUnChampsTableHTML( "Protection des vaisseaux spatiaux " , rapport.Recherches.ProtectionDesVaisseauxSpatiaux , 14 ) ;
                s += AfficherUnChampsTableHTML( "Technologie Energie "               , rapport.Recherches.Energie                        , 12 ) ;
                s += AfficherUnChampsTableHTML( "Technologie Hyperespace "           , rapport.Recherches.Hyperespace                    ,  9 ) ;
                s += AfficherUnChampsTableHTML( "Réacteur à combustion "             , rapport.Recherches.ReacteurACombustion            , 12 ) ;
                s += AfficherUnChampsTableHTML( "Réacteur à impulsion "              , rapport.Recherches.ReacteurAImpulsion             , 10 ) ;
                s += AfficherUnChampsTableHTML( "Propulsion hyperespace "            , rapport.Recherches.PropulsionHyperespace          ,  8 ) ;
                s += AfficherUnChampsTableHTML( "Technologie Laser "                 , rapport.Recherches.Laser                          , 11 ) ;
                s += AfficherUnChampsTableHTML( "Technologie Ions "                  , rapport.Recherches.Ions                           , 10 ) ;
                s += AfficherUnChampsTableHTML( "Technologie Plasma "                , rapport.Recherches.Plasma                         ,  8 ) ;
                s += AfficherUnChampsTableHTML( "Réseau de recherche intergalatique ", rapport.Recherches.ReseauDeRechercheIntergalactique, 1 ) ;
                s += AfficherUnChampsTableHTML( "Technologie Graviton "              , rapport.Recherches.Graviton                       ,  1 ) ;
                s += "</tr></table>" ;
            }}}}
            s += "   </body>" +
"</html>" ;
            return s ;
        }
    }
}


