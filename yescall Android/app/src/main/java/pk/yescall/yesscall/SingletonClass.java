package pk.yescall.yesscall;



import org.json.JSONObject;



public class SingletonClass {

    private static SingletonClass instance;
public static String apiToken;
public static String name;
public static JSONObject object;
public static boolean isLogin;

    public static SingletonClass getInstance() {
        if (instance == null)
            instance = new SingletonClass();
        return instance;

    }

    private SingletonClass() {
    }
    public  void setValues(String apiToken,String name,JSONObject object,boolean isLogin){
        this.name=name;
        this.apiToken=apiToken;
        this.object=object;
        this.isLogin=isLogin;
    }
    public String getApiToken(){
        return apiToken;
    }
    public String getName(){
        return name;
    }
    public JSONObject balanceDetail(){
        return object;
    }
    public boolean isIsLogin(){
        return isLogin;
    }
    }
